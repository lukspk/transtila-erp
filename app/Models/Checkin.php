<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entrega_id',
        'motorista_id',
        'latitude',
        'longitude',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}
