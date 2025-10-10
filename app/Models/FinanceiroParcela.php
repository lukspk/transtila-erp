<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceiroParcela extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function financeiro()
    {
        return $this->belongsTo(Financeiro::class);
    }
}
