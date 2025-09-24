<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Services\EntregaService;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    protected $entregaService;

    public function __construct(EntregaService $entregaService)
    {
        $this->entregaService = $entregaService;
    }

    public function index()
    {
        $entregas = $this->entregaService->listar();
        return view('entregas.index', compact('entregas'));
    }

    public function create()
    {
        return view('entregas.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string']);
        $this->entregaService->criar($request->all());
        return redirect()->route('entregas.index');
    }

    public function edit(Entrega $entrega)
    {
        return view('entregas.edit', compact('entrega'));
    }

    public function update(Request $request, Entrega $entrega)
    {
        $request->validate(['nome' => 'required|string']);
        $this->entregaService->atualizar($entrega, $request->all());
        return redirect()->route('entregas.index');
    }

    public function destroy(Entrega $entrega)
    {
        $this->entregaService->deletar($entrega);
        return redirect()->route('entregas.index');
    }
}
