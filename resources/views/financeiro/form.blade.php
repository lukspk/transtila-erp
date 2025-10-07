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
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="formFinanceiro" action="{{ route('financeiro.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="tipo" class="form-label">Tipo</label>
                                        <select name="tipo" id="tipo" class="form-select" required>
                                            <option value="">Selecione...</option>
                                            <option value="PAGAR">Conta a Pagar</option>
                                            <option value="RECEBER">Conta a Receber</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="financeiro_categoria_id" class="form-label">Categoria</label>
                                        <select name="financeiro_categoria_id" id="financeiro_categoria_id"
                                            class="form-select" required>
                                            <option selected>Selecione...</option>
                                            @forelse ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                            @empty
                                                <option value="">Nenhuma categoria encontrada</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea name="descricao" class="form-control" rows="3" placeholder="Detalhes"
                                            required></textarea>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="valor" class="form-label">Valor (R$)</label>
                                        <input type="text" name="valor" id="valor" class="form-control" placeholder="0,00"
                                            required>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                        <input type="date" name="data_vencimento" class="form-control" required>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="Pendente" selected>Pendente</option>
                                            <option value="Pago">Pago</option>
                                            <option value="Atrasado">Atrasado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="col-12 d-flex align-items-center mt-4">
                                        <a href="{{ route('financeiro.index') }}"
                                            class="btn btn-outline-secondary px-4 me-2">Cancelar</a>
                                        <button type="submit" class="btn btn-success px-4">Salvar</button>
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


            $('#valor').mask('#.##0,00', { reverse: true });


        });
    </script>
@endsection