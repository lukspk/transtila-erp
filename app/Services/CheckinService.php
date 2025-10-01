<?php

namespace App\Services;

use App\Models\Checkin;
use App\Models\Entrega;
use App\Models\Motorista;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckinService
{
    /**
     * Retorna a chave secreta para a geração de hashes.
     */
    private function getSecretKey(): string
    {
        return env('CHECKIN_HASH_SECRET');
    }

    /**
     * Encontra uma entrega com base no seu hash.
     * Retorna o objeto Entrega ou null se não encontrar.
     */
    public function getEntregaFromHash(string $entregaHash)
    {
        $secret = $this->getSecretKey();

        return Entrega::all()->first(function ($entrega) use ($entregaHash, $secret) {
            return hash('sha256', $entrega->id . $secret) === $entregaHash;
        });
    }


    public function getMotoristaFromHash(string $motoristaHash)
    {
        $secret = $this->getSecretKey();

        return Motorista::all()->first(function ($motorista) use ($motoristaHash, $secret) {
            return hash('sha256', $motorista->id . $secret) === $motoristaHash;
        });
    }


    public function store(array $data)
    {
        return Checkin::create([
            'entrega_id' => $data['entrega_id'],
            'motorista_id' => $data['motorista_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);
    }

    public function generateCheckinLink(Entrega $entrega, Motorista $motorista): string
    {
        $secret = $this->getSecretKey();

        $entregaHash = hash('sha256', $entrega->id . $secret);
        $motoristaHash = hash('sha256', $motorista->id . $secret);

        return route('checkin.show', [
            'entregaHash' => $entregaHash,
            'motoristaHash' => $motoristaHash,
        ]);
    }
}