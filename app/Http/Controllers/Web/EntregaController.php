<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Services\EntregaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntregaController extends Controller
{
    protected $entregaService;

    public function __construct(EntregaService $entregaService)
    {
        $this->entregaService = $entregaService;
    }
    public function index()
    {
        $entregas = Entrega::with('motorista')->get();
        return view('entregas.index', compact('entregas'));
    }

    public function create()
    {
        return view('entregas.form');
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
        return view('entregas.form', compact('entrega'));
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

    public function show(Entrega $entrega)
    {
        $entrega->load('motorista');

        return view('entregas.show', compact('entrega'));
    }

}
