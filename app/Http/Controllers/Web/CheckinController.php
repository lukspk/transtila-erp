<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Services\CheckinService;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    protected $checkinService;


    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }


    public function showCheckinPage($entregaHash, $motoristaHash)
    {

        $entrega = $this->checkinService->getEntregaFromHash($entregaHash);
        $motorista = $this->checkinService->getMotoristaFromHash($motoristaHash);

        if (!$entrega || !$motorista) {
            abort(404, 'Link de check-in inválido ou expirado.');
        }

        return view('checkin.show', [
            'entregaHash' => $entregaHash,
            'motoristaHash' => $motoristaHash,
            'motorista' => $motorista,
            'entrega' => $entrega,
        ]);
    }


    public function storeCheckin(Request $request)
    {

        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'entregaHash' => 'required|string',
            'motoristaHash' => 'required|string',
        ]);


        $entrega = $this->checkinService->getEntregaFromHash($validatedData['entregaHash']);
        $motorista = $this->checkinService->getMotoristaFromHash($validatedData['motoristaHash']);

        if (!$entrega || !$motorista) {
            return response()->json(['message' => 'Autorização inválida.'], 403);
        }

        $this->checkinService->store([
            'entrega_id' => $entrega->id,
            'motorista_id' => $motorista->id,
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return response()->json(['message' => 'Check-in realizado com sucesso!']);
    }

    public function show(Entrega $entrega)
    {
        $checkinLink = null; // Inicia a variável como nula

        // 5. Gera o link SE a entrega tiver um motorista
        if ($entrega->motorista) {
            $checkinLink = $this->checkinService->generateCheckinLink($entrega, $entrega->motorista);
        }

        // 6. Envia a variável (seja ela nula ou a URL) para a view
        return view('entregas.show', compact('entrega', 'checkinLink'));
    }
}
