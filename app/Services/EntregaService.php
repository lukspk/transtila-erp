<?php

namespace App\Services;

use App\Models\Entrega;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EntregaService
{
    public function criar(array $data)
    {
        return Entrega::create($data);
    }

    public function listar()
    {
        return Entrega::with('contasAPagar')->get();
    }

    public function atualizar(Entrega $entrega, array $data): bool
    {
        return $entrega->update($data);
    }

    public function deletar(Entrega $entrega): bool
    {
        return $entrega->delete();
    }
}