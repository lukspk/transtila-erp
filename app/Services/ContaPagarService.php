<?php

namespace App\Services;

use App\Models\ContaPagar;

class ContaPagarService
{
    public function store(array $data): ContaPagar
    {
        return ContaPagar::create($data);
    }
}