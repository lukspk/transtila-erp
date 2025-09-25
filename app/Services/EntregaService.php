<?php

namespace App\Services;

use App\Models\Entrega;
use App\Models\Motorista;
use Illuminate\Support\Facades\DB;

class EntregaService
{

    public function criarEntrega(array $dadosEntrega, array $dadosMotorista)
    {
        return DB::transaction(function () use ($dadosEntrega, $dadosMotorista) {


            $motorista = Motorista::firstOrCreate(
                ['cpf' => $dadosMotorista['cpf']],
                [
                    'nome' => $dadosMotorista['nome'],
                    'telefone' => $dadosMotorista['telefone'] ?? null,
                    'rntrc' => $dadosMotorista['rntrc'] ?? null,
                    'user_id' => $dadosMotorista['user_id'] ?? null,
                ]
            );


            $entrega = Entrega::create(array_merge($dadosEntrega, [
                'motorista_id' => $motorista->id
            ]));

            return $entrega;
        });
    }
}
