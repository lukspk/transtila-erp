@extends('layouts.maxton')
@section('title', isset($user) ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
    @php
        $isEdit = isset($user);
        $oldName = old('name', $isEdit ? $user->name : '');
        $oldEmail = old('email', $isEdit ? $user->email : '');
        $selectedRole = old('role_id', ($isEdit && $user->roles->count()) ? $user->roles->first()->id : '');
    @endphp

    <main class="main-wrapper">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>{{ $isEdit ? 'Editar Usuário' : 'Cadastrar Usuário' }}</h4>
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

                        <form action="{{ $isEdit ? route('users.update', $user->id) : route('users.store') }}" method="POST"
                            class="row g-3">
                            @csrf
                            @if($isEdit) @method('PUT') @endif

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $oldName }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $oldEmail }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Senha {{ $isEdit ? '(deixe em branco para não alterar)' : '' }}
                                </label>
                                <input type="password" name="password" id="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6">
                                <label for="role_id" class="form-label">Role</label>
                                <select name="role_id" id="role_id" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $selectedRole == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <button type="submit" class="btn btn-{{ $isEdit ? 'primary' : 'success' }} px-4 me-2">
                                    {{ $isEdit ? 'Atualizar' : 'Salvar' }}
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Voltar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection