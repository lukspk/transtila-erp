@extends('layouts.maxton')
@section('title', 'Editar Usuário')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Cadastra Usuário</h4>
                <a href="{{ route('users.create') }}" class="btn btn-primary px-4 d-none">
                    Adicionar Usuário
                </a>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Senha <small>(deixe em branco para não
                                        alterar)</small></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="role_id" class="form-label">Roles</label>
                                <select name="role_id[]" id="role_id" class="form-select" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4 me-2">Atualizar</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Voltar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
@endsection