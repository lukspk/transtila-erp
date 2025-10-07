<?php

namespace App\Services;

use App\Models\Financeiro;

class FinanceiroService
{
    public function getAllPaginated()
    {
        return Financeiro::with('financeiroCategoria')
            ->orderBy('data_vencimento', 'desc')
            ->paginate(15);
    }

    public function store(array $data): Financeiro
    {
        return Financeiro::create($data);
    }

    public function formatarValorParaBanco(?string $valor): float
    {
        if (is_null($valor)) {
            return 0.0;
        }
        $valorLimpo = str_replace('.', '', $valor);
        $valorLimpo = str_replace(',', '.', $valorLimpo);
        return (float) $valorLimpo;
    }
}