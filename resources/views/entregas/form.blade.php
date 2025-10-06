@extends('layouts.maxton')

{{-- Título dinâmico: 'Editar Entrega' ou 'Nova Entrega' --}}
@section('title', isset($entrega) ? 'Editar Entrega' : 'Nova Entrega')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Entregas</h4>
                <a href="{{ route('entregas.upload.create') }}"
                    class="btn btn-primary px-4 {{ isset($entrega) ? 'd-none' : '' }}">
                    Importar PDF
                </a>
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
                                @if (isset($entrega))
                                    @method('PUT')
                                @endif




                                <div class="col">
                                    <ul class="nav nav-tabs nav-primary" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                                aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bi bi-house-door me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Entrega</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                                                aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Motorista</div>
                                                </div>
                                            </a>
                                        </li>
                                        @if (isset($entrega))
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab"
                                                    aria-selected="false">
                                                    <div class="d-flex align-items-center">
                                                        <div class="tab-icon"><i class='bi bi-headset me-1 fs-6'></i>
                                                        </div>
                                                        <div class="tab-title">Contas a Pagar</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>

                                    <div class="tab-content py-3">
                                        <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                            <div class="mb-4">
                                                <h5 class="mb-3">Dados da Entrega</h5>
                                                <div class="row g-3">
                                                    <div class="col-12 col-lg-4">
                                                        <input type="text" name="modelo" class="form-control"
                                                            placeholder="Modelo" required
                                                            value="{{ $entrega->modelo ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <input type="number" name="serie" class="form-control"
                                                            placeholder="Série" required
                                                            value="{{ $entrega->serie ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <input type="number" name="numero" class="form-control"
                                                            placeholder="Número" required
                                                            value="{{ $entrega->numero ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="chave_acesso" class="form-control"
                                                            placeholder="Chave de Acesso" required
                                                            value="{{ $entrega->chave_acesso ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="datetime-local" name="data_hora_emissao"
                                                            class="form-control" placeholder="Data/Hora Emissão"
                                                            value="{{ $entrega->data_hora_emissao ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="protocolo_autorizacao" class="form-control"
                                                            placeholder="Protocolo de Autorização"
                                                            value="{{ $entrega->protocolo_autorizacao ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="modal" class="form-control"
                                                            placeholder="Modal" value="{{ $entrega->modal ?? '' }}">
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
                                                        <input type="number" name="qtd_cte" class="form-control"
                                                            placeholder="Qtd CTE" value="{{ $entrega->qtd_cte ?? '' }}">
                                                    </div>
                                                    <div class="col-6 col-lg-3">
                                                        <input type="number" name="qtd_nfe" class="form-control"
                                                            placeholder="Qtd NFE" value="{{ $entrega->qtd_nfe ?? '' }}">
                                                    </div>
                                                    <div class="col-6 col-lg-6">
                                                        <input type="number" step="0.01" name="peso_total_kg"
                                                            class="form-control" placeholder="Peso Total (kg)"
                                                            value="{{ $entrega->peso_total_kg ?? '' }}">
                                                    </div>
                                                    <div class="col-6 col-lg-6">
                                                        <input type="number" step="0.01" name="valor_total_carga"
                                                            class="form-control" placeholder="Valor Total da Carga"
                                                            value="{{ $entrega->valor_total_carga ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <h5 class="mb-3">Emitente</h5>
                                                <div class="row g-3">
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="emitente_nome" name="emitente_nome"
                                                            class="form-control" placeholder="Nome do Emitente"
                                                            value="{{ $entrega->emitente_nome ?? 'TRANSTILA SOLUCOES' }}"
                                                            required>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="emitente_cnpj" name="emitente_cnpj"
                                                            class="form-control" placeholder="CNPJ do Emitente" required
                                                            value="{{ $entrega->emitente_cnpj ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="emitente_ie" name="emitente_ie"
                                                            class="form-control" placeholder="Inscrição Estadual" required
                                                            value="{{ $entrega->emitente_ie ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="emitente_rntrc" name="emitente_rntrc"
                                                            class="form-control" placeholder="RNTRC" required
                                                            value="{{ $entrega->emitente_rntrc ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="emitente_logradouro"
                                                            name="emitente_logradouro" class="form-control"
                                                            placeholder="Logradouro" required
                                                            value="{{ $entrega->emitente_logradouro ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-3">
                                                        <input type="text" id="emitente_numero_logradouro"
                                                            name="emitente_numero_logradouro" class="form-control"
                                                            placeholder="Número" required
                                                            value="{{ $entrega->emitente_numero_logradouro ?? '' }}">
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
                                                        <input type="text" id="emitente_uf" name="emitente_uf"
                                                            class="form-control" placeholder="UF" maxlength="2" required
                                                            value="{{ $entrega->emitente_uf ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-3">
                                                        <input type="text" id="emitente_cep" name="emitente_cep"
                                                            class="form-control" placeholder="CEP" required
                                                            value="{{ $entrega->emitente_cep ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- DADOS DO VEÍCULO --}}
                                            <div class="mb-4">
                                                <h5 class="mb-3">Veículo</h5>
                                                <div class="row g-3">
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="veiculo_placa_principal"
                                                            class="form-control" placeholder="Placa Principal" required
                                                            value="{{ $entrega->veiculo_placa_principal ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="veiculo_rntrc_principal"
                                                            class="form-control" placeholder="RNTRC Principal" required
                                                            value="{{ $entrega->veiculo_rntrc_principal ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="veiculo_placa_secundaria"
                                                            class="form-control" placeholder="Placa Secundária"
                                                            value="{{ $entrega->veiculo_placa_secundaria ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" name="veiculo_rntrc_secundario"
                                                            class="form-control" placeholder="RNTRC Secundário"
                                                            value="{{ $entrega->veiculo_rntrc_secundario ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DADOS DO SEGURO --}}
                                            <div class="mb-4">
                                                <h5 class="mb-3">Seguro</h5>
                                                <div class="row g-3">
                                                    <div class="col-12 col-lg-4">
                                                        <input type="text" name="seguro_responsavel_cnpj"
                                                            class="form-control" placeholder="CNPJ Responsável"
                                                            value="{{ $entrega->seguro_responsavel_cnpj ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <input type="text" name="seguro_apolice" class="form-control"
                                                            placeholder="Apolice"
                                                            value="{{ $entrega->seguro_apolice ?? '' }}">
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <input type="text" name="seguro_averbacao" class="form-control"
                                                            placeholder="Averbação"
                                                            value="{{ $entrega->seguro_averbacao ?? '' }}">
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
                                                            placeholder="Número CIOT"
                                                            value="{{ $entrega->ciot_numero ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- OBSERVAÇÕES --}}
                                            <div class="mb-4">
                                                <h5 class="mb-3">Observações</h5>
                                                <textarea name="observacoes" class="form-control" rows="3"
                                                    placeholder="Digite observações">{{ $entrega->observacoes ?? '' }}</textarea>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                            <div class="mb-4">
                                                <h5 class="mb-3">Motorista</h5>
                                                <div class="row g-3">
                                                    <div class="col-12 col-lg-6">
                                                        <input type="text" id="motorista_cpf" name="motorista_cpf"
                                                            class="form-control" placeholder="CPF do Motorista" required
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
                                        </div>
                                        @if (isset($entrega))
                                            {{-- SUBSTITUA O CONTEÚDO DENTRO DE #primarycontact POR ISTO --}}
                                            <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Contas Vinculadas</h5>
                                                    {{-- Botão que abre o modal --}}
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#modalAdicionarConta">
                                                        <i class="bi bi-plus"></i> Adicionar Conta
                                                    </button>
                                                </div>

                                                {{-- A LISTA (tabela) onde as contas vão aparecer --}}
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Despesa</th>
                                                                <th>Valor (R$)</th>
                                                                <th class="text-end">Ações</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listaContasAdicionadas">
                                                            {{-- Se estiver a editar, mostra as contas que já existem --}}
                                                            @if(isset($entrega) && $entrega->contasPagar->isNotEmpty())
                                                                @foreach($entrega->contasPagar as $conta)
                                                                    <tr>
                                                                        {{-- Inputs escondidos com os dados que serão salvos no final
                                                                        --}}
                                                                        <input type="hidden"
                                                                            name="contas[{{ $loop->index }}][despesa_id]"
                                                                            value="{{ $conta->despesa_id }}">
                                                                        <input type="hidden" name="contas[{{ $loop->index }}][valor]"
                                                                            value="{{ $conta->valor }}">

                                                                        <td>{{ $conta->despesa->nome }}</td>
                                                                        <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                                                                        <td class="text-end">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-danger delete-btn"
                                                                                data-route="{{ route('entregas.contas.delete.ajax', $conta->id) }}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <p id="semContasMsg"
                                                    class="text-center text-muted mt-3 {{ (isset($entrega) && $entrega->contasPagar->isNotEmpty()) ? 'd-none' : '' }}">
                                                    Nenhuma conta adicionada.
                                                </p>
                                            </div>
                                            <br>
                                        @endif
                                        <div class="col-12 d-flex align-items-center">
                                            <a href="{{ route('entregas.index') }}"
                                                class="btn btn-outline-secondary px-4 me-2">Voltar</a>
                                            <button type="submit"
                                                class="btn btn-{{ isset($entrega) ? 'primary' : 'success' }} px-4">{{ isset($entrega) ? 'Atualizar' : 'Adicionar' }}</button>
                                        </div>
                                    </div>
                                    {{--
                                </div>
                        </div> --}}
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
                            <option value="0" @if (isset($entrega) && $entrega->categoria == 0) selected @endif>Frete
                            </option>
                            <option value="1" @if (isset($entrega) && $entrega->categoria == 1) selected @endif>Carga
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


    @if (isset($entrega))
        <div class="modal fade" id="modalAdicionarConta" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Conta a Pagar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="selectDespesa" class="form-label">Tipo de Despesa</label>
                            <select id="selectDespesa" name="despesa_id" class="form-select" required>
                                @if ($despesas->count() > 0)
                                    <option value="">Selecione uma despesa...</option>
                                    @foreach ($despesas as $despesa)
                                        <option value="{{ $despesa->id }}">{{ $despesa->nome }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled selected>Nenhuma despesa cadastrada</option>
                                @endif
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="inputValor" class="form-label">Valor (R$)</label>
                            <input type="text" class="form-control" id="inputValor" maxlength="15" placeholder="150.50">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmarAddConta">Adicionar à Lista</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(function () {
            'use strict';
            $('#inputValor').mask('#.##0,00', { reverse: true });
            $('#btnConfirmarAddConta').on('click', function () {
                const despesaId = $('#selectDespesa').val();
                const valor = $('#inputValor').val();
                const url = '{{ isset($entrega) ? route("entregas.contas.store.ajax", $entrega->id) : '' }}';

                if (!url) {
                    alert('ERRO: A funcionalidade de adicionar contas só está disponível ao editar uma entrega.');
                    return;
                }
                if (!despesaId || !valor) {
                    alert('Selecione uma despesa e preencha o valor.');
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true).html('A Salvar...');


                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        despesa_id: despesaId,
                        valor: valor,
                    },
                    success: function (novaContaSalva) {
                        const valorFormatado = parseFloat(novaContaSalva.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

                        const novaLinha = `
                                                                                                                        <tr>
                                                                                                                            <td>${novaContaSalva.despesa.nome}</td>
                                                                                                                            <td>R$ ${valorFormatado}</td>
                                                                                                                            <td class="text-end">
                                                                                                                                <button type="button" class="btn btn-sm btn-danger btn-remover-conta">Excluir</button>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    `;

                        $('#listaContasAdicionadas').append(novaLinha);
                        $('#semContasMsg').addClass('d-none');
                        $('#selectDespesa').val('');
                        $('#inputValor').val('');
                        $('#modalAdicionarConta').modal('hide');
                    },
                    error: function (xhr) {
                        alert('Ocorreu um erro ao salvar. Verifique os dados e tente novamente.');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('Adicionar à Lista');
                    }
                });
            });

            $('#listaContasAdicionadas').on('click', '.btn-remover-conta', function () {

                if (confirm('Tem certeza que deseja remover esta conta? A ação será permanente.')) {
                    $(this).closest('tr').remove();
                    if ($('#listaContasAdicionadas tr').length === 0) {
                        $('#semContasMsg').removeClass('d-none');
                    }
                }
            });

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