@extends('layouts.maxton')
@section('title', 'Lista de Entregas')

@section('content')
    @auth
        <main class="main-wrapper">
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Lista de Entregas</h4>
                    <a href="{{ route('entregas.create') }}" class="btn btn-primary px-4">
                        Nova Entrega
                    </a>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Motorista</th>
                                        <th scope="col">Modelo / Série / Número</th>
                                        <th scope="col">Chave de Acesso</th>
                                        <th scope="col">Data Emissão</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entregas as $entrega)
                                        <tr>
                                            <th scope="row">{{ $entrega->id }}</th>
                                            <td>{{ $entrega->motorista->nome ?? '-' }}</td>
                                            <td>{{ $entrega->modelo }} / {{ $entrega->serie }} / {{ $entrega->numero }}</td>
                                            <td>{{ $entrega->chave_acesso }}</td>
                                            <td>{{ $entrega->data_hora_emissao ? $entrega->data_hora_emissao->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('entregas.create', $entrega->id) }}"
                                                    class="btn btn-sm btn-info">Ver</a>
                                                <a href="{{ route('entregas.edit', $entrega->id) }}"
                                                    class="btn btn-sm btn-warning">Editar</a>
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-route="{{ route('entregas.destroy', $entrega->id) }}">
                                                    Excluir
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Nenhuma entrega encontrada.</td>
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
