@extends('layouts.maxton')
@section('title', 'Novo')


@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Financeiro</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('financeiro.index') }}"><i
                                        class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Novo</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        {{-- ABA PARA CADASTRAR CONTA A PAGAR --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#pagar" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bi bi-arrow-down-circle me-1 fs-6"></i></div>
                                    <div class="tab-title">Nova Despesa (A Pagar)</div>
                                </div>
                            </a>
                        </li>
                        {{-- ABA PARA CADASTRAR CONTA A RECEBER --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#receber" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bi bi-arrow-up-circle me-1 fs-6"></i></div>
                                    <div class="tab-title">Nova Receita (A Receber)</div>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content py-3">
                        {{-- DIV/FORMULÁRIO PARA CONTAS A PAGAR --}}
                        <div class="tab-pane fade show active" id="pagar" role="tabpanel">
                            <form action="{{ route('financeiro.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipo" value="PAGAR">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Nome</label>
                                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="categoria_pagar" class="form-label">Categoria da Despesa</label>
                                        {{-- SELECT NORMAL, SEM SELECT2 --}}
                                        <select name="financeiro_categoria_id" id="categoria_pagar" class="form-select"
                                            required>
                                            <option value="">Selecione uma categoria...</option>
                                            {{-- Popula com as categorias de PAGAR --}}
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Descrição</label>
                                        <textarea name="descricao" class="form-control" rows="2"
                                            placeholder="Detalhes da despesa" required></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Valor (R$)</label>
                                        <input type="text" name="valor" class="form-control mask-valor" placeholder="0,00"
                                            id="valorPagar" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Data de Vencimento</label>
                                        <input type="date" name="data_vencimento" class="form-control" required>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="Pendente" selected>Pendente</option>
                                            <option value="Pago">Pago</option>
                                            <option value="Atrasado">Atrasado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- DIV/FORMULÁRIO PARA CONTAS A RECEBER --}}
                        <div class="tab-pane fade" id="receber" role="tabpanel">
                            <form action="{{ route('financeiro.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipo" value="RECEBER">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Nome</label>
                                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="categoria_receber" class="form-label">Categoria da Receita</label>
                                        {{-- SELECT NORMAL, SEM SELECT2 --}}
                                        <select name="financeiro_categoria_id" id="categoria_receber" class="form-select"
                                            required>
                                            <option value="">Selecione uma categoria...</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Descrição</label>
                                        <textarea name="descricao" class="form-control" rows="2"
                                            placeholder="Detalhes da receita" required></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Valor (R$)</label>
                                        <input type="text" name="valor" class="form-control mask-valor" placeholder="0,00"
                                            id="valorReceber" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Data de Vencimento</label>
                                        <input type="date" name="data_vencimento" class="form-control" required>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="Pendente" selected>Pendente</option>
                                            <option value="Pago">Pago</option>
                                            <option value="Atrasado">Atrasado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(function () {
            'use strict';


            $('#valorPagar').mask('#.##0,00', { reverse: true });
            $('#valorReceber').mask('#.##0,00', { reverse: true });


        });
    </script>
@endsection