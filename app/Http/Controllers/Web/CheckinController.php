<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Entrega;
use App\Services\CheckinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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


    public function capturarDocumento($id)
    {
        $entrega = Entrega::findOrFail($id);
        $documentos = $entrega->documentos;
        return view('checkin.upload', compact('entrega', 'documentos'));
    }


    public function uploadDocumento(Request $request, $id)
    {
        $entrega = Entrega::findOrFail($id);


        $request->validate([
            'image' => 'required|string'
        ]);

        $imageData = $request->image;
        $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $decoded = base64_decode($imageData);

        if ($decoded === false) {
            return response()->json(['message' => 'Erro ao processar a imagem.'], 400);
        }

        $folder = 'entregas';
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        $fileName = 'entrega_' . $entrega->id . '_' . time() . '.jpg';
        $path = $folder . '/' . $fileName;

        Storage::disk('public')->put($path, $decoded);

        $documento = Documento::create([
            'entrega_id' => $entrega->id,
            'arquivo' => $path,
            'tipo' => 'comprovante',
        ]);

        return response()->json([
            'message' => '📸 Documento salvo com sucesso!',
            'documento_id' => $documento->id,
            'url' => asset('storage/' . $path),
        ]);
    }

}
