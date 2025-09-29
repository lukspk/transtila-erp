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
                                                    class="btn btn-sm btn-primary d-none">Ver</a>
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">Editar</a>
                                                @if($user->id !== auth()->user()->id)
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-route="{{ route('users.destroy', $user->id) }}">Excluir</button>
                                                @endif
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

@section('script')
    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                var btn = $(this);
                var route = btn.data('route');

                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Essa ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: { _method: 'DELETE' },
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            success: function (data) {
                                Swal.fire('Deletado!', data.message, 'success');
                                btn.closest('tr').remove();
                            },
                            error: function () {
                                Swal.fire('Erro!', 'Algo deu errado.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection