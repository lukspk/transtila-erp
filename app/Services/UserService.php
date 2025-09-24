<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function store(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach($data['role_id']);

        return $user;
    }

    public function index()
    {
        return User::with('roles')->get();
    }

    public function update(User $user, array $data): bool
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $update = $user->update($data);

        if (isset($data['role_id'])) {
            if (is_array($data['role_id'])) {
                $user->roles()->sync($data['role_id']);
            } else {
                $user->roles()->sync([$data['role_id']]);
            }
        }


        return $update;
    }

    public function destroy(User $user): bool
    {
        $user->roles()->detach();
        return $user->delete();
    }
}