<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ChatPdfService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CHATPDF_API_KEY');
    }

    /**
     * Extrai dados do DAMDFE a partir de um arquivo PDF enviado.
     */
    public function extractDamdfDataFromFile($uploadedFile): array
    {
        if (!$uploadedFile) {
            throw new Exception('Arquivo não enviado.');
        }
        Log::info('Arquivo enviado para ChatPDF', [
            'path' => $uploadedFile->getPathname(),
            'name' => $uploadedFile->getClientOriginalName(),
            'size' => $uploadedFile->getSize()
        ]);
        $prompt = "
A partir do documento DAMDFE em anexo, extraia as seguintes informações e retorne-as estritamente no formato JSON. Não inclua nenhuma explicação, apenas o JSON.
- modelo (string)
- serie (string)
- numero (string)
- chave_acesso (string, remova todos os espaços)
- data_hora_emissao (string, no formato YYYY-MM-DD HH:MM:SS)
- protocolo_autorizacao (string)
- modal (string)
- uf_carregamento (string)
- uf_descarregamento (string)
- qtd_cte (integer)
- qtd_nfe (integer)
- peso_total_kg (float, use ponto como separador decimal)
- valor_total_carga (float, use ponto como separador decimal)
- observacoes (string)
- emitente (objeto com: nome, cnpj, ie, rntrc, logradouro, numero_logradouro, bairro, municipio, uf, cep)
- motorista (objeto com: nome, cpf)
- veiculos (array de objetos, cada um com: placa, rntrc)
- seguro (objeto com: responsavel_cnpj, apolice, averbacao)
- ciot (objeto com: responsavel_cnpj, numero)
";

        try {
            // 1️⃣ Upload do arquivo para ChatPDF
            $response = $this->client->post('https://api.chatpdf.com/v1/sources/add-file', [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($uploadedFile->getPathname(), 'r'),
                        'filename' => $uploadedFile->getClientOriginalName(),
                    ],
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Recebido do PDF', [
                'pdf' => $result

            ]);
            $sourceId = $result['sourceId'] ?? null; // ⚠ usar sourceId conforme documentação

            if (!$sourceId) {
                throw new Exception('Não foi possível adicionar o PDF no ChatPDF.');
            }

            // 2️⃣ Enviar prompt para extrair os dados
            $response = $this->client->post('https://api.chatpdf.com/v1/chats/message', [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'sourceId' => $sourceId,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Recebido do PDF', [
                'result' => $result

            ]);
            $jsonData = $result['content'] ?? null;

            if (!$jsonData) {
                throw new Exception('Não foi possível extrair os dados do PDF.');
            }

            // Limpa o Markdown ```json ... ```
            $jsonData = trim($jsonData);
            $jsonData = preg_replace('/^```json\s*/', '', $jsonData);
            $jsonData = preg_replace('/\s*```$/', '', $jsonData);

            // Agora decodifica
            $dados = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON inválido retornado pelo ChatPDF: ' . json_last_error_msg());
            }

            return $dados;


        } catch (Exception $e) {
            throw new Exception('Erro ao comunicar com ChatPDF: ' . $e->getMessage());
        }
    }
}
