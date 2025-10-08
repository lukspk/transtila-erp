<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Financeiro;
use App\Models\FinanceiroCategoria;
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

    public function create()
    {
        $categorias = FinanceiroCategoria::orderBy('nome')->get();
        return view('financeiro.form', compact('categorias'));
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
                'financeiro_categoria_id' => 'required|exists:financeiro_categorias,id',
                'valor' => 'required|numeric|min:0.01',
                'data_vencimento' => 'required|date',
                'status' => 'required|in:Pendente,Pago,Atrasado,Cancelado',
            ]);

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
}
