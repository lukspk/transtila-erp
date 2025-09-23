<?php

namespace App\Services;

use App\Models\ContaPagar;
use App\Models\Entrega;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContaPagarService
{

    public function criar(array $data)
    {
        return ContaPagar::create($data);
    }

    public function listarPorEntrega(int $entregaId)
    {
        return ContaPagar::where('entrega_id', $entregaId)->get();
    }

    public function atualizar(ContaPagar $conta, array $data): bool
    {
        return $conta->update($data);
    }

    public function deletar(ContaPagar $conta): bool
    {
        return $conta->delete();
    }
}