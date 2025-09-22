<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function users()
    {
        // O Laravel entende que a tabela de ligação é 'role_user' pela convenção de nomes.
        return $this->belongsToMany(User::class);
    }
}
