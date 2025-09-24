@extends('layouts.maxton')
@section('title', 'Dashboard')
@section('content')
    @auth
        <main class="main-wrapper">
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Lista de Usuários</h4>
                    <a href="{{ route('users.create') }}" class="btn btn-primary px-4">
                        Adicionar Usuário
                    </a>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Funções</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                {{ $user->roles->pluck('name')->implode(', ') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('users.index', $user->id) }}"
                                                    class="btn btn-sm btn-info d-none">Ver</a>
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning">Editar</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline"
                                                    onsubmit="return confirm('Tem certeza que deseja deletar este usuário? Esta ação não pode ser desfeita!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">Nenhum usuário encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endauth
@endsection