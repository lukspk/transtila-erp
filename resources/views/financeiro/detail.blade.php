@extends('layouts.maxton')
@section('title', 'Detalhes')

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Financeiro</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item active" aria-current="page">Detalhes
                            #{{ $financeiro->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Card com os detalhes --}}
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Resumo</h5>
                <p><strong>Nome:</strong> {{ $financeiro->nome }}</p>
                <p><strong>Descrição:</strong> {{ $financeiro->descricao }}</p>
                <p><strong>Valor Total:</strong> R$ {{ number_format($financeiro->valor, 2, ',', '.') }}</p>
                <p><strong>Status Geral:</strong>
                    @if($financeiro->status == 'Pago')
                    <span class="badge bg-success">{{ $financeiro->status }}</span>
                    @else
                    <span class="badge bg-warning">{{ $financeiro->status }}</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Card com a lista de Parcelas --}}
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Parcelas</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th># Parcela</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th class="text-end">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financeiro->parcelas as $parcela)
                            <tr>
                                <td>{{ $parcela->numero_parcela }} de {{ $financeiro->parcelas->count() }}</td>
                                <td>R$ {{ number_format($parcela->valor_parcela, 2, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                                <td>
                                    @if($parcela->status == 'Pago')
                                    <span class="badge bg-success">{{ $parcela->status }}</span>
                                    @else
                                    <span class="badge bg-warning">{{ $parcela->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($parcela->status == 'Pendente')
                                    <form action="{{ route('financeiro.parcela.pagar', $parcela->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Marcar como Paga</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection