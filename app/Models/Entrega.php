<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data_hora_emissao' => 'datetime',
    ];
    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class)->orderBy('created_at', 'desc');
    }

    public function contasPagar()
    {
        return $this->hasMany(ContaPagar::class);
    }

}
