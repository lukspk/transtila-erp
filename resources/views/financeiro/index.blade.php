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
                    <a href="{{ route('financeiro.create') }}" class="btn btn-primary px-4">
                        Novo
                    </a>
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
                                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-route="#">
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

                    {{-- Links de paginação --}}
                    @if($financeiros->hasPages())
                        <div class="mt-3">
                            {{ $financeiros->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    {{-- Aqui podemos adicionar o script de exclusão no futuro --}}
@endsection