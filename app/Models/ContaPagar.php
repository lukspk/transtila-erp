<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaPagar extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function despesa()
    {
        return $this->belongsTo(Despesa::class);
    }
}
