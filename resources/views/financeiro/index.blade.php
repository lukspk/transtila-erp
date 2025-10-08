@extends('layouts.maxton')
@section('title', 'Financeiro - Lançamentos')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Financeiro</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#modalPagar">
                        Adicionar Despesa
                    </button>
                    <button type="button" class="btn btn-success px-4" data-bs-toggle="modal"
                        data-bs-target="#modalReceber">
                        Adicionar Receita
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Vencimento</th>
                                    <th>Status</th>
                                    <th>Tipo</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($financeiros as $financeiro)
                                    <tr>
                                        <td>{{ $financeiro->nome }}</td>
                                        <td>{{ $financeiro->descricao }}</td>
                                        <td class="fw-bold {{ $financeiro->tipo == 'PAGAR' ? 'text-danger' : 'text-success' }}">
                                            R$ {{ number_format($financeiro->valor, 2, ',', '.') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($financeiro->data_vencimento)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($financeiro->status == 'Pendente')
                                                <span class="badge bg-warning">{{ $financeiro->status }}</span>
                                            @elseif($financeiro->status == 'Pago')
                                                <span class="badge bg-success">{{ $financeiro->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $financeiro->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($financeiro->tipo == 'PAGAR')
                                                <span class="badge bg-danger">{{ $financeiro->tipo }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $financeiro->tipo }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            {{-- <a href="#" class="btn btn-sm btn-warning">Editar</a> --}}
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                data-route="{{ route('financeiro.delete', $financeiro->id) }}">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Nenhum encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($financeiros->hasPages())
                        <div class="mt-3">
                            {{ $financeiros->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalPagar" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Nova Despesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tipo" value="PAGAR">
                    <div class="mb-3"><label class="form-label">Nome</label><input type="text" name="nome"
                            class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Categoria</label><select name="financeiro_categoria_id"
                            class="form-select" required>
                            <option value="">Selecione...</option>@foreach($categorias as $cat)
                            <option value="{{$cat->id}}">{{$cat->nome}}</option>@endforeach
                        </select></div>
                    <div class="mb-3"><label class="form-label">Descrição</label><textarea name="descricao"
                            class="form-control" rows="2" required></textarea></div>
                    <div class="row">
                        <div class="col-4"><label class="form-label">Valor (R$)</label><input type="text" name="valor"
                                class="form-control mask-valor" required></div>
                        <div class="col-4"><label class="form-label">Vencimento</label><input type="date"
                                name="data_vencimento" class="form-control" required></div>
                        <div class="col-4 ">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Pendente" selected>Pendente</option>
                                <option value="Pago">Pago</option>
                                <option value="Atrasado">Atrasado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button><button type="submit"
                        class="btn btn-primary">Salvar</button></div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalReceber" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Nova Receita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tipo" value="RECEBER">
                    <div class="mb-3"><label class="form-label">Nome</label><input type="text" name="nome"
                            class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Categoria</label><select name="financeiro_categoria_id"
                            class="form-select" required>
                            <option value="">Selecione...</option>@foreach($categorias as $cat)
                            <option value="{{$cat->id}}">{{$cat->nome}}</option>@endforeach
                        </select></div>
                    <div class="mb-3"><label class="form-label">Descrição</label><textarea name="descricao"
                            class="form-control" rows="2" required></textarea></div>
                    <div class="row">
                        <div class="col-4"><label class="form-label">Valor (R$)</label><input type="text" name="valor"
                                class="form-control mask-valor" required></div>
                        <div class="col-4"><label class="form-label">Vencimento</label><input type="date"
                                name="data_vencimento" class="form-control" required></div>
                        <div class="col-4 ">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Pendente" selected>Pendente</option>
                                <option value="Pago">Pago</option>
                                <option value="Atrasado">Atrasado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button><button type="submit"
                        class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(function () {
            'use strict';
            $('[name="valor"]').mask('#.##0,00', { reverse: true });
        });

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

                                Swal.fire({
                                    title: 'Deletado!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
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