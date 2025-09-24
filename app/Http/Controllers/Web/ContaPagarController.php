<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContaPagar;
use App\Models\Entrega;
use App\Services\ContaPagarService;
use Illuminate\Http\Request;

class ContaPagarController extends Controller
{
    protected $contaPagarService;

    public function __construct(ContaPagarService $contaPagarService)
    {
        $this->contaPagarService = $contaPagarService;
    }

    public function index()
    {
        $contas = ContaPagar::with('entrega')->get();
        return view('contas.index', compact('contas'));
    }

    public function create()
    {
        $entregas = Entrega::all();
        return view('contas.create', compact('entregas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'valor' => 'required|numeric',
            'entrega_id' => 'required|exists:entregas,id',
        ]);
        $this->contaPagarService->criar($request->all());
        return redirect()->route('contas.index');
    }

    public function edit(ContaPagar $conta)
    {
        $entregas = Entrega::all();
        return view('contas.edit', compact('conta', 'entregas'));
    }

    public function update(Request $request, ContaPagar $conta)
    {
        $request->validate([
            'nome' => 'required|string',
            'valor' => 'required|numeric',
            'entrega_id' => 'required|exists:entregas,id',
        ]);
        $this->contaPagarService->atualizar($conta, $request->all());
        return redirect()->route('contas.index');
    }

    public function destroy(ContaPagar $conta)
    {
        $this->contaPagarService->deletar($conta);
        return redirect()->route('contas.index');
    }
}
