@extends('layouts.maxton')
@section('title', 'Editar Entrega')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Entregas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('entregas.index') }}"><i
                                        class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar Entrega</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="formEntrega" action="{{ route('entregas.update', $entrega->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- DADOS DO MOTORISTA --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Motorista</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="motorista_cpf" name="motorista_cpf" class="form-control"
                                                placeholder="CPF do Motorista" value="{{ $entrega->motorista->cpf ?? '' }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="motorista_nome" name="motorista_nome"
                                                class="form-control" placeholder="Nome do Motorista"
                                                value="{{ $entrega->motorista->nome ?? '' }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="motorista_rntrc" name="motorista_rntrc"
                                                class="form-control" placeholder="RNTRC do Motorista"
                                                value="{{ $entrega->motorista->rntrc ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- DADOS DA ENTREGA --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Dados da Entrega</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="modelo" class="form-control" placeholder="Modelo"
                                                value="{{ $entrega->modelo }}" required>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="number" name="serie" class="form-control" placeholder="Série"
                                                value="{{ $entrega->serie }}" required>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="number" name="numero" class="form-control" placeholder="Número"
                                                value="{{ $entrega->numero }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="chave_acesso" class="form-control"
                                                placeholder="Chave de Acesso" value="{{ $entrega->chave_acesso }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="datetime-local" name="data_hora_emissao" class="form-control"
                                                value="{{ $entrega->data_hora_emissao ? $entrega->data_hora_emissao->format('Y-m-d\TH:i') : '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="protocolo_autorizacao" class="form-control"
                                                placeholder="Protocolo de Autorização"
                                                value="{{ $entrega->protocolo_autorizacao }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="modal" class="form-control" placeholder="Modal"
                                                value="{{ $entrega->modal }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="text" name="uf_carregamento" class="form-control"
                                                placeholder="UF Carregamento" maxlength="2"
                                                value="{{ $entrega->uf_carregamento }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="text" name="uf_descarregamento" class="form-control"
                                                placeholder="UF Descarregamento" maxlength="2"
                                                value="{{ $entrega->uf_descarregamento }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="number" name="qtd_cte" class="form-control" placeholder="Qtd CTE"
                                                value="{{ $entrega->qtd_cte }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="number" name="qtd_nfe" class="form-control" placeholder="Qtd NFE"
                                                value="{{ $entrega->qtd_nfe }}">
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <input type="number" step="0.01" name="peso_total_kg" class="form-control"
                                                placeholder="Peso Total (kg)" value="{{ $entrega->peso_total_kg }}">
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <input type="number" step="0.01" name="valor_total_carga" class="form-control"
                                                placeholder="Valor Total da Carga"
                                                value="{{ $entrega->valor_total_carga }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- EMITENTE --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Emitente</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_nome" name="emitente_nome" class="form-control"
                                                placeholder="Nome do Emitente" value="{{ $entrega->emitente_nome }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_cnpj" name="emitente_cnpj" class="form-control"
                                                placeholder="CNPJ do Emitente" value="{{ $entrega->emitente_cnpj }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_ie" name="emitente_ie" class="form-control"
                                                placeholder="Inscrição Estadual" value="{{ $entrega->emitente_ie }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_rntrc" name="emitente_rntrc"
                                                class="form-control" placeholder="RNTRC"
                                                value="{{ $entrega->emitente_rntrc }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_logradouro" name="emitente_logradouro"
                                                class="form-control" placeholder="Logradouro"
                                                value="{{ $entrega->emitente_logradouro }}" required>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_numero_logradouro"
                                                name="emitente_numero_logradouro" class="form-control" placeholder="Número"
                                                value="{{ $entrega->emitente_numero_logradouro }}" required>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_bairro" name="emitente_bairro"
                                                class="form-control" placeholder="Bairro"
                                                value="{{ $entrega->emitente_bairro }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_municipio" name="emitente_municipio"
                                                class="form-control" placeholder="Município"
                                                value="{{ $entrega->emitente_municipio }}" required>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_uf" name="emitente_uf" class="form-control"
                                                placeholder="UF" maxlength="2" value="{{ $entrega->emitente_uf }}" required>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_cep" name="emitente_cep" class="form-control"
                                                placeholder="CEP" value="{{ $entrega->emitente_cep }}" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- VEÍCULO --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Veículo</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_placa_principal" class="form-control"
                                                placeholder="Placa Principal"
                                                value="{{ $entrega->veiculo_placa_principal }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_rntrc_principal" class="form-control"
                                                placeholder="RNTRC Principal"
                                                value="{{ $entrega->veiculo_rntrc_principal }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_placa_secundaria" class="form-control"
                                                placeholder="Placa Secundária"
                                                value="{{ $entrega->veiculo_placa_secundaria }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_rntrc_secundario" class="form-control"
                                                placeholder="RNTRC Secundário"
                                                value="{{ $entrega->veiculo_rntrc_secundario }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- SEGURO --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Seguro</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_responsavel_cnpj" class="form-control"
                                                placeholder="CNPJ Responsável"
                                                value="{{ $entrega->seguro_responsavel_cnpj }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_apolice" class="form-control"
                                                placeholder="Apolice" value="{{ $entrega->seguro_apolice }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_averbacao" class="form-control"
                                                placeholder="Averbação" value="{{ $entrega->seguro_averbacao }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- CIOT --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">CIOT</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="ciot_responsavel_cnpj" class="form-control"
                                                placeholder="CNPJ Responsável"
                                                value="{{ $entrega->ciot_responsavel_cnpj }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="ciot_numero" class="form-control"
                                                placeholder="Número CIOT" value="{{ $entrega->ciot_numero }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- OBSERVAÇÕES --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Observações</h5>
                                    <textarea name="observacoes" class="form-control" rows="3"
                                        placeholder="Digite observações">{{ $entrega->observacoes }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-outline-danger">Descartar</button>
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Organização</h5>
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select class="form-select" name="categoria">
                                    <option value="0" {{ $entrega->categoria == 0 ? 'selected' : '' }}>Frete</option>
                                    <option value="1" {{ $entrega->categoria == 1 ? 'selected' : '' }}>Carga</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Digite tags"
                                    value="{{ $entrega->tags }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Ações</h5>
                            <div class="d-flex flex-column gap-2">
                                <button type="button" class="btn btn-outline-danger">Descartar</button>
                                <button type="submit" form="formEntrega" class="btn btn-outline-success">Salvar
                                    Rascunho</button>
                                <button type="submit" class="btn btn-outline-primary">Publicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </main>
@endsection