<?php

namespace App\Services;

use App\Models\Financeiro;
use App\Models\FinanceiroParcela;
use Carbon\Carbon;

class FinanceiroService
{
    public function getAllPaginated()
    {
        return Financeiro::with('financeiroCategoria')
            ->orderBy('data_vencimento', 'desc')
            ->paginate(20);
    }

    public function store(array $data): Financeiro
    {
        // 1. Pega o número de parcelas e remove-o dos dados principais
        $numeroParcelas = (int) $data['numero_parcelas'];
        unset($data['numero_parcelas']);

        $lancamentoPai = Financeiro::create($data);


        $valorTotal = (float) $data['valor'];
        $valorParcela = round($valorTotal / $numeroParcelas, 2);


        $somaParcelas = $valorParcela * $numeroParcelas;
        $diferenca = $valorTotal - $somaParcelas;


        for ($i = 1; $i <= $numeroParcelas; $i++) {
            $valorDaParcelaAtual = $valorParcela;
            if ($i == $numeroParcelas) {
                $valorDaParcelaAtual += $diferenca;
            }

            $lancamentoPai->parcelas()->create([
                'numero_parcela' => $i,
                'valor_parcela' => $valorDaParcelaAtual,
                'data_vencimento' => Carbon::parse($data['data_vencimento'])->addMonths($i - 1),
                'status' => 'Pendente',
            ]);
        }

        return $lancamentoPai;
    }


    public function deletarConta(Financeiro $financeiro)
    {
        return $financeiro->delete();
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



    public function pagar(FinanceiroParcela $parcela): void
    {
        $lancamentoPai = $parcela->financeiro;

        $parcela->status = 'Pago';
        $parcela->data_pagamento = now();
        $parcela->save();

        $this->verificarEAtualizarStatusDoPai($lancamentoPai);
    }

    public function verificarEAtualizarStatusDoPai(Financeiro $lancamentoPai): void
    {
        $parcelasPendentes = $lancamentoPai->parcelas()->where('status', '!=', 'Pago')->count();

        if ($parcelasPendentes === 0) {
            $lancamentoPai->status = 'Pago';
            $lancamentoPai->save();
        }
    }

}