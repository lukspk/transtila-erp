<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function criar(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach($data['role_id']);

        return $user;
    }

    public function listar()
    {
        return User::all();
    }

    public function atualizar(User $user, array $data): bool
    {
        if (isset($data['senha'])) {
            $data['senha'] = Hash::make($data['senha']);
        }
        return $user->update($data);
    }

    public function deletar(User $user): bool
    {
        return $user->delete();
    }
}