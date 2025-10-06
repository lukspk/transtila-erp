<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Despesa;
use App\Models\Entrega;
use App\Services\ChatPdfService;
use App\Services\CheckinService;
use App\Services\ContaPagarService;
use App\Services\EntregaService;
use App\Services\GeminiPdfExtractorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EntregaController extends Controller
{
    protected $entregaService;
    protected $chatPdfService;

    protected $checkinService;
    protected $contaPagarService;



    public function __construct(EntregaService $entregaService, ChatPdfService $chatPdfService, CheckinService $checkinService, ContaPagarService $contaPagarService)
    {
        $this->entregaService = $entregaService;
        $this->chatPdfService = $chatPdfService;
        $this->checkinService = $checkinService;
        $this->contaPagarService = $contaPagarService;
    }
    public function index()
    {
        $entregas = Entrega::with('motorista')->get();
        return view('entregas.index', compact('entregas'));
    }

    public function create()
    {
        $despesas = Despesa::orderBy('nome')->get();
        return view('entregas.form', compact('despesas'));
    }

    /**
     * Processa os dados da entrega
     */
    public function store(Request $request)
    {

        $dadosMotorista = [
            'nome' => $request->motorista_nome,
            'cpf' => $request->motorista_cpf,
            'rntrc' => $request->motorista_rntrc ?? null,
            'user_id' => null,
        ];

        $dadosEntrega = $request->only([
            'modelo',
            'serie',
            'numero',
            'chave_acesso',
            'data_hora_emissao',
            'protocolo_autorizacao',
            'modal',
            'uf_carregamento',
            'uf_descarregamento',
            'qtd_cte',
            'qtd_nfe',
            'peso_total_kg',
            'valor_total_carga',
            'emitente_nome',
            'emitente_cnpj',
            'emitente_ie',
            'emitente_rntrc',
            'emitente_logradouro',
            'emitente_numero_logradouro',
            'emitente_bairro',
            'emitente_municipio',
            'emitente_uf',
            'emitente_cep',
            'veiculo_placa_principal',
            'veiculo_rntrc_principal',
            'veiculo_placa_secundaria',
            'veiculo_rntrc_secundario',
            'seguro_responsavel_cnpj',
            'seguro_apolice',
            'seguro_averbacao',
            'ciot_responsavel_cnpj',
            'ciot_numero',
            'observacoes'
        ]);

        $entrega = $this->entregaService->criarEntrega($dadosEntrega, $dadosMotorista);

        return redirect()->route('entregas.index')->with('success', 'Entrega criada com sucesso!');
    }

    public function edit(Entrega $entrega)
    {
        $despesas = Despesa::orderBy('nome')->get();
        return view('entregas.form', compact('entrega', 'despesas'));
    }

    public function update(Request $request, Entrega $entrega)
    {
        $dadosMotorista = [
            'nome' => $request->motorista_nome,
            'cpf' => $request->motorista_cpf,
            'rntrc' => $request->motorista_rntrc ?? null,
            'user_id' => null,
        ];

        $dadosEntrega = $request->only([
            'modelo',
            'serie',
            'numero',
            'chave_acesso',
            'data_hora_emissao',
            'protocolo_autorizacao',
            'modal',
            'uf_carregamento',
            'uf_descarregamento',
            'qtd_cte',
            'qtd_nfe',
            'peso_total_kg',
            'valor_total_carga',
            'emitente_nome',
            'emitente_cnpj',
            'emitente_ie',
            'emitente_rntrc',
            'emitente_logradouro',
            'emitente_numero_logradouro',
            'emitente_bairro',
            'emitente_municipio',
            'emitente_uf',
            'emitente_cep',
            'veiculo_placa_principal',
            'veiculo_rntrc_principal',
            'veiculo_placa_secundaria',
            'veiculo_rntrc_secundario',
            'seguro_responsavel_cnpj',
            'seguro_apolice',
            'seguro_averbacao',
            'ciot_responsavel_cnpj',
            'ciot_numero',
            'observacoes'
        ]);

        $this->entregaService->atualizarEntrega($entrega, $dadosEntrega, $dadosMotorista);

        return redirect()->route('entregas.index')->with('success', 'Entrega atualizada com sucesso!');
    }
    public function destroy(Entrega $entrega)
    {
        $this->entregaService->deletarEntrega($entrega);

        return response()->json(['message' => 'Entrega deletada com sucesso!']);
    }

    // public function show(Entrega $entrega)
    // {
    //     $entrega->load('motorista');

    //     return view('entregas.show', compact('entrega'));
    // }



    public function showUploadForm()
    {
        return view('entregas.upload');
    }


    public function processarUpload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $uploadedFile = $request->file('pdf_file');

        try {

            $dados = $this->chatPdfService->extractDamdfDataFromFile($uploadedFile);

            Log::info('Dados recebidos', [
                'Dados:' => $dados
            ]);

            $dadosMotorista = [
                'nome' => $dados['motorista']['nome'] ?? null,
                'cpf' => $dados['motorista']['cpf'] ?? null,
                'rntrc' => $dados['motorista']['rntrc'] ?? null,
                'user_id' => null,
            ];

            $dadosEntrega = [
                'modelo' => $dados['modelo'] ?? null,
                'serie' => $dados['serie'] ?? null,
                'numero' => $dados['numero'] ?? null,
                'chave_acesso' => $dados['chave_acesso'] ?? null,
                'data_hora_emissao' => $dados['data_hora_emissao'] ?? null,
                'protocolo_autorizacao' => $dados['protocolo_autorizacao'] ?? null,
                'modal' => $dados['modal'] ?? null,
                'uf_carregamento' => $dados['uf_carregamento'] ?? null,
                'uf_descarregamento' => $dados['uf_descarregamento'] ?? null,
                'qtd_cte' => $dados['qtd_cte'] ?? null,
                'qtd_nfe' => $dados['qtd_nfe'] ?? null,
                'peso_total_kg' => $dados['peso_total_kg'] ?? null,
                'valor_total_carga' => $dados['valor_total_carga'] ?? null,
                'emitente_nome' => $dados['emitente']['nome'] ?? null,
                'emitente_cnpj' => $dados['emitente']['cnpj'] ?? null,
                'emitente_ie' => $dados['emitente']['ie'] ?? null,
                'emitente_rntrc' => $dados['emitente']['rntrc'] ?? null,
                'emitente_logradouro' => $dados['emitente']['logradouro'] ?? null,
                'emitente_numero_logradouro' => $dados['emitente']['numero_logradouro'] ?? null,
                'emitente_bairro' => $dados['emitente']['bairro'] ?? null,
                'emitente_municipio' => $dados['emitente']['municipio'] ?? null,
                'emitente_uf' => $dados['emitente']['uf'] ?? null,
                'emitente_cep' => $dados['emitente']['cep'] ?? null,
                'veiculo_placa_principal' => $dados['veiculos'][0]['placa'] ?? null,
                'veiculo_rntrc_principal' => $dados['veiculos'][0]['rntrc'] ?? null,
                'veiculo_placa_secundaria' => $dados['veiculos'][1]['placa'] ?? null,
                'veiculo_rntrc_secundario' => $dados['veiculos'][1]['rntrc'] ?? null,
                'seguro_responsavel_cnpj' => $dados['seguro']['responsavel_cnpj'] ?? null,
                'seguro_apolice' => $dados['seguro']['apolice'] ?? null,
                'seguro_averbacao' => $dados['seguro']['averbacao'] ?? null,
                'ciot_responsavel_cnpj' => $dados['ciot']['responsavel_cnpj'] ?? null,
                'ciot_numero' => $dados['ciot']['numero'] ?? null,
                'observacoes' => $dados['observacoes'] ?? null,
            ];

            // Salvar no banco
            $this->entregaService->criarEntrega($dadosEntrega, $dadosMotorista);

            return redirect()->route('entregas.index')->with('success', 'Entrega criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao processar PDF: ' . $e->getMessage());
        }
    }


    public function show(Entrega $entrega)
    {

        $entrega->load('motorista', 'checkins');

        $checkinLink = null;

        if ($entrega->motorista) {
            $checkinLink = $this->checkinService->generateCheckinLink($entrega, $entrega->motorista);
        }

        return view('entregas.show', compact('entrega', 'checkinLink'));
    }

    public function storeAjax(Request $request, Entrega $entrega)
    {
        $data = $request->validate([
            'despesa_id' => 'required|exists:despesas,id',
            'valor' => 'required|numeric|min:0.01',
        ]);

        $data['entrega_id'] = $entrega->id;

        $novaConta = $this->contaPagarService->store($data);

        return response()->json($novaConta->load('despesa'));
    }
}
