@extends('layouts.maxton')

{{-- Título dinâmico: 'Editar Entrega' ou 'Nova Entrega' --}}
@section('title', isset($entrega) ? 'Editar Entrega' : 'Nova Entrega')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Entregas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('entregas.index') }}"><i
                                        class="bx bx-home-alt"></i></a></li>
                            {{-- Breadcrumb dinâmico --}}
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($entrega) ? 'Editar Entrega' : 'Nova Entrega' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            {{-- Action e Method dinâmicos --}}
                            <form id="formEntrega"
                                action="{{ isset($entrega) ? route('entregas.update', $entrega) : route('entregas.store') }}"
                                method="POST">
                                @csrf
                                {{-- Adiciona o método PUT para edição --}}
                                @if(isset($entrega))
                                    @method('PUT')
                                @endif

                                {{-- DADOS DO MOTORISTA --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Motorista</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="motorista_cpf" name="motorista_cpf" class="form-control"
                                                placeholder="CPF do Motorista" required
                                                value="{{ $entrega->motorista->cpf ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="motorista_nome" name="motorista_nome"
                                                class="form-control" placeholder="Nome do Motorista" required
                                                value="{{ $entrega->motorista->nome ?? '' }}">
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
                                                required value="{{ $entrega->modelo ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="number" name="serie" class="form-control" placeholder="Série"
                                                required value="{{ $entrega->serie ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="number" name="numero" class="form-control" placeholder="Número"
                                                required value="{{ $entrega->numero ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="chave_acesso" class="form-control"
                                                placeholder="Chave de Acesso" required
                                                value="{{ $entrega->chave_acesso ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="datetime-local" name="data_hora_emissao" class="form-control"
                                                placeholder="Data/Hora Emissão"
                                                value="{{ $entrega->data_hora_emissao ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="protocolo_autorizacao" class="form-control"
                                                placeholder="Protocolo de Autorização"
                                                value="{{ $entrega->protocolo_autorizacao ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="modal" class="form-control" placeholder="Modal"
                                                value="{{ $entrega->modal ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="text" name="uf_carregamento" class="form-control"
                                                placeholder="UF Carregamento" maxlength="2"
                                                value="{{ $entrega->uf_carregamento ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="text" name="uf_descarregamento" class="form-control"
                                                placeholder="UF Descarregamento" maxlength="2"
                                                value="{{ $entrega->uf_descarregamento ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="number" name="qtd_cte" class="form-control" placeholder="Qtd CTE"
                                                value="{{ $entrega->qtd_cte ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input type="number" name="qtd_nfe" class="form-control" placeholder="Qtd NFE"
                                                value="{{ $entrega->qtd_nfe ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <input type="number" step="0.01" name="peso_total_kg" class="form-control"
                                                placeholder="Peso Total (kg)" value="{{ $entrega->peso_total_kg ?? '' }}">
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <input type="number" step="0.01" name="valor_total_carga" class="form-control"
                                                placeholder="Valor Total da Carga"
                                                value="{{ $entrega->valor_total_carga ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3">Emitente</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_nome" name="emitente_nome" class="form-control"
                                                placeholder="Nome do Emitente"
                                                value="{{ $entrega->emitente_nome ?? 'TRANSTILA SOLUCOES' }}" required>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_cnpj" name="emitente_cnpj" class="form-control"
                                                placeholder="CNPJ do Emitente" required
                                                value="{{ $entrega->emitente_cnpj ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_ie" name="emitente_ie" class="form-control"
                                                placeholder="Inscrição Estadual" required
                                                value="{{ $entrega->emitente_ie ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_rntrc" name="emitente_rntrc"
                                                class="form-control" placeholder="RNTRC" required
                                                value="{{ $entrega->emitente_rntrc ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_logradouro" name="emitente_logradouro"
                                                class="form-control" placeholder="Logradouro" required
                                                value="{{ $entrega->emitente_logradouro ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_numero_logradouro"
                                                name="emitente_numero_logradouro" class="form-control" placeholder="Número"
                                                required value="{{ $entrega->emitente_numero_logradouro ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_bairro" name="emitente_bairro"
                                                class="form-control" placeholder="Bairro" required
                                                value="{{ $entrega->emitente_bairro ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" id="emitente_municipio" name="emitente_municipio"
                                                class="form-control" placeholder="Município" required
                                                value="{{ $entrega->emitente_municipio ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_uf" name="emitente_uf" class="form-control"
                                                placeholder="UF" maxlength="2" required
                                                value="{{ $entrega->emitente_uf ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <input type="text" id="emitente_cep" name="emitente_cep" class="form-control"
                                                placeholder="CEP" required value="{{ $entrega->emitente_cep ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                                {{-- DADOS DO VEÍCULO --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Veículo</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_placa_principal" class="form-control"
                                                placeholder="Placa Principal" required
                                                value="{{ $entrega->veiculo_placa_principal ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_rntrc_principal" class="form-control"
                                                placeholder="RNTRC Principal" required
                                                value="{{ $entrega->veiculo_rntrc_principal ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_placa_secundaria" class="form-control"
                                                placeholder="Placa Secundária"
                                                value="{{ $entrega->veiculo_placa_secundaria ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="veiculo_rntrc_secundario" class="form-control"
                                                placeholder="RNTRC Secundário"
                                                value="{{ $entrega->veiculo_rntrc_secundario ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- DADOS DO SEGURO --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Seguro</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_responsavel_cnpj" class="form-control"
                                                placeholder="CNPJ Responsável"
                                                value="{{ $entrega->seguro_responsavel_cnpj ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_apolice" class="form-control"
                                                placeholder="Apolice" value="{{ $entrega->seguro_apolice ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <input type="text" name="seguro_averbacao" class="form-control"
                                                placeholder="Averbação" value="{{ $entrega->seguro_averbacao ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- DADOS DO CIOT --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">CIOT</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="ciot_responsavel_cnpj" class="form-control"
                                                placeholder="CNPJ Responsável"
                                                value="{{ $entrega->ciot_responsavel_cnpj ?? '' }}">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="text" name="ciot_numero" class="form-control"
                                                placeholder="Número CIOT" value="{{ $entrega->ciot_numero ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- OBSERVAÇÕES --}}
                                <div class="mb-4">
                                    <h5 class="mb-3">Observações</h5>
                                    <textarea name="observacoes" class="form-control" rows="3"
                                        placeholder="Digite observações">{{ $entrega->observacoes ?? '' }}</textarea>
                                </div>

                                <div class="col-12 d-flex align-items-center">
                                    <a href="{{ route('entregas.index') }}"
                                        class="btn btn-outline-secondary px-4 me-2">Voltar</a>
                                    <button type="submit"
                                        class="btn btn-{{ isset($entrega) ? 'primary' : 'success' }} px-4">{{ isset($entrega) ? 'Atualizar' : 'Adicionar' }}</button>
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
                                    <option value="0" @if(isset($entrega) && $entrega->categoria == 0) selected @endif>Frete
                                    </option>
                                    <option value="1" @if(isset($entrega) && $entrega->categoria == 1) selected @endif>Carga
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Digite tags"
                                    value="{{ $entrega->tags ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Ações</h5>
                            <div class="d-flex flex-column gap-2">
                                <button type="button" class="btn btn-outline-danger">Descartar</button>
                                <button type="submit" form="formEntrega" class="btn btn-outline-success">Salvar
                                    Rascunho</button>
                                <button type="submit" class="btn btn-outline-primary">Publicar</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>
@endsection