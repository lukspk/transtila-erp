<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Financeiro;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroParcela;
use App\Services\FinanceiroService;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    protected $financeiroService;

    public function __construct(FinanceiroService $financeiroService)
    {
        $this->financeiroService = $financeiroService;
    }

    public function index()
    {
        $financeiros = $this->financeiroService->getAllPaginated();
        $categorias = FinanceiroCategoria::orderBy('nome')->get();

        return view('financeiro.index', compact('financeiros', 'categorias'));
    }


    public function store(Request $request)
    {
        $request->merge([
            'valor' => $this->financeiroService->formatarValorParaBanco($request->input('valor'))
        ]);


        try {
            $dadosValidados = $request->validate([
                'tipo' => 'required|in:PAGAR,RECEBER',
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'financeiro_categoria_id' => 'required',
                'valor' => 'required|numeric|min:0.01',
                'data_vencimento' => 'required|date',
                'status' => 'required|in:Pendente,Pago,Atrasado,Cancelado',
                'numero_parcelas' => 'integer|min:1',
            ]);


            $categoriaInput = $dadosValidados['financeiro_categoria_id'];
            if (!is_numeric($categoriaInput)) {
                $categoria = FinanceiroCategoria::firstOrCreate(
                    ['nome' => $categoriaInput]
                );

                $dadosValidados['financeiro_categoria_id'] = $categoria->id;
            }


            $this->financeiroService->store($dadosValidados);

            return redirect()->route('financeiro.index')->with('success', 'criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar financeiro: ' . $e->getMessage());
        }
    }

    public function deletarConta(Financeiro $financeiro)
    {
        try {
            $this->financeiroService->deletarConta($financeiro);
            return response()->json([
                'success' => true,
                'message' => 'Conta deletado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar conta: ' . $e->getMessage()
            ]);
        }

    }
    public function showDetail(Financeiro $financeiro)
    {
        return view('financeiro.detail', ['financeiro' => $financeiro->load('parcelas')]);
    }

    public function pagar(FinanceiroParcela $parcela)
    {
        $this->financeiroService->pagar($parcela);
        return back()->with('success', 'Parcela paga com sucesso!');
    }
}
