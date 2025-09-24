<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->listar();
        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|string|min:6',
        ]);

        $this->service->criar($request->all());
        return redirect()->route('usuarios.index');
    }

    public function edit(User $user)
    {
        return view('usuarios.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'senha' => 'nullable|string|min:6',
        ]);

        $this->service->atualizar($user, $request->all());
        return redirect()->route('usuarios.index');
    }

    public function destroy(User $user)
    {
        $this->service->deletar($user);
        return redirect()->route('usuarios.index');
    }
}
