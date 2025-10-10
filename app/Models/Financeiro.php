<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function financeiroCategoria()
    {
        return $this->belongsTo(FinanceiroCategoria::class);
    }
    public function parcelas()
    {
        return $this->hasMany(FinanceiroParcela::class)->orderBy('numero_parcela', 'asc');
    }
}
