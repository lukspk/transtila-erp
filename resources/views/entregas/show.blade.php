@extends('layouts.maxton')
@section('title', 'Detalhes da Entrega')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha26-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #checkinMap {
            height: 300px;
        }

        /* Define a altura do mapa */
    </style>
@endsection
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
                            <li class="breadcrumb-item active" aria-current="page">Detalhes da Entrega</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('entregas.edit', $entrega->id) }}" class="btn btn-primary">Editar Entrega</a>
                </div>
            </div>
            <!--end breadcrumb-->

            <!-- Entrega Info Cards -->
            <div class="row g-3">

                <!-- Motorista -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-center">
                            <i class="bi bi-person-circle fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Motorista</h5>
                                <p class="mb-0"><strong>Nome:</strong> {{ $entrega->motorista->nome ?? '-' }}</p>
                                <p class="mb-0"><strong>CPF:</strong> {{ $entrega->motorista->cpf ?? '-' }}</p>
                                <p class="mb-0"><strong>RNTRC:</strong> {{ $entrega->motorista->rntrc ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados da Entrega -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-card-checklist fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Dados da Entrega</h5>
                                <p class="mb-0"><strong>Modelo:</strong> {{ $entrega->modelo }}</p>
                                <p class="mb-0"><strong>Série:</strong> {{ $entrega->serie }}</p>
                                <p class="mb-0"><strong>Número:</strong> {{ $entrega->numero }}</p>
                                <p class="mb-0"><strong>Chave de Acesso:</strong> {{ $entrega->chave_acesso }}</p>
                                <p class="mb-0"><strong>Data/Hora Emissão:</strong>
                                    {{ $entrega->data_hora_emissao->format('d/m/Y H:i') }}</p>
                                <p class="mb-0"><strong>Protocolo:</strong> {{ $entrega->protocolo_autorizacao ?? '-' }}</p>
                                <p class="mb-0"><strong>Modal:</strong> {{ $entrega->modal }}</p>
                                <p class="mb-0"><strong>UF Carregamento:</strong> {{ $entrega->uf_carregamento }}</p>
                                <p class="mb-0"><strong>UF Descarregamento:</strong> {{ $entrega->uf_descarregamento }}</p>
                                <p class="mb-0"><strong>Qtd CTE:</strong> {{ $entrega->qtd_cte }}</p>
                                <p class="mb-0"><strong>Qtd NFE:</strong> {{ $entrega->qtd_nfe }}</p>
                                <p class="mb-0"><strong>Peso Total:</strong> {{ $entrega->peso_total_kg }} kg</p>
                                <p class="mb-0"><strong>Valor Total Carga:</strong> R$
                                    {{ number_format($entrega->valor_total_carga, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emitente -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-building fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Emitente</h5>
                                <p class="mb-0"><strong>Nome:</strong> {{ $entrega->emitente_nome }}</p>
                                <p class="mb-0"><strong>CNPJ:</strong> {{ $entrega->emitente_cnpj }}</p>
                                <p class="mb-0"><strong>IE:</strong> {{ $entrega->emitente_ie }}</p>
                                <p class="mb-0"><strong>RNTRC:</strong> {{ $entrega->emitente_rntrc }}</p>
                                <p class="mb-0"><strong>Endereço:</strong> {{ $entrega->emitente_logradouro }},
                                    {{ $entrega->emitente_numero_logradouro }} - {{ $entrega->emitente_bairro }},
                                    {{ $entrega->emitente_municipio }} - {{ $entrega->emitente_uf }}, CEP:
                                    {{ $entrega->emitente_cep }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Veículo -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-truck fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Veículo</h5>
                                <p class="mb-0"><strong>Placa Principal:</strong> {{ $entrega->veiculo_placa_principal }}
                                </p>
                                <p class="mb-0"><strong>RNTRC Principal:</strong> {{ $entrega->veiculo_rntrc_principal }}
                                </p>
                                <p class="mb-0"><strong>Placa Secundária:</strong>
                                    {{ $entrega->veiculo_placa_secundaria ?? '-' }}</p>
                                <p class="mb-0"><strong>RNTRC Secundário:</strong>
                                    {{ $entrega->veiculo_rntrc_secundario ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seguro -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-shield-lock fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Seguro</h5>
                                <p class="mb-0"><strong>CNPJ Responsável:</strong> {{ $entrega->seguro_responsavel_cnpj }}
                                </p>
                                <p class="mb-0"><strong>Apolice:</strong> {{ $entrega->seguro_apolice }}</p>
                                <p class="mb-0"><strong>Averbação:</strong> {{ $entrega->seguro_averbacao }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CIOT -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-file-earmark-text fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">CIOT</h5>
                                <p class="mb-0"><strong>CNPJ Responsável:</strong> {{ $entrega->ciot_responsavel_cnpj }}</p>
                                <p class="mb-0"><strong>Número CIOT:</strong> {{ $entrega->ciot_numero }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <i class="bi bi-journal-text fs-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Observações</h5>
                                <p class="mb-0">{{ $entrega->observacoes ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if($entrega->checkins->isNotEmpty())
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-3 align-items-center mb-3">
                                    <i class="bi bi-pin-map-fill fs-3 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Histórico de Check-ins ({{ $entrega->checkins->count() }})</h5>
                                    </div>
                                </div>

                                <div id="checkinMap" class="mb-3"></div>

                                <ul class="list-group">
                                    @foreach($entrega->checkins as $checkin)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Registrado em: {{ $checkin->created_at->format('d/m/Y H:i:s') }}
                                            <a href="https://www.google.com/maps?q={{ $checkin->latitude }},{{ $checkin->longitude }}"
                                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                                Ver no Google Maps
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($checkinLink)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex gap-3 align-items-center">
                                <i class="bi bi-geo-alt-fill fs-3 text-primary"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Rastreio / Check-in</h5>
                                    <p class="mb-2">Envie o link abaixo para o motorista registrar a localização.</p>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $checkinLink }}" id="checkinLinkInput"
                                            readonly>
                                        <button class="btn btn-outline-primary" type="button" id="copyCheckinLinkBtn">
                                            <i class="bi bi-clipboard"></i> Copiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('script')

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>

        $(function () {
            console.log('Script da página de detalhes da entrega iniciado.');


            const $copyBtn = $('#copyCheckinLinkBtn');

            if ($copyBtn.length) {
                $copyBtn.on('click', function () {
                    const $linkInput = $('#checkinLinkInput');
                    const originalText = $(this).html();

                    navigator.clipboard.writeText($linkInput.val()).then(() => {
                        $(this).html('<i class="bi bi-check-lg"></i> Copiado!')
                            .removeClass('btn-outline-primary')
                            .addClass('btn-success');

                        setTimeout(() => {
                            $(this).html(originalText)
                                .removeClass('btn-success')
                                .addClass('btn-outline-primary');
                        }, 2000);
                    }).catch(err => {
                        console.error('Erro ao copiar o link: ', err);
                        alert('Não foi possível copiar o link.');
                    });
                });
            }



            @if ($entrega->checkins->isNotEmpty())


                const checkinData = @json($entrega->checkins->map(function ($c) {
                    return [
                        'lat' => (float) $c->latitude,
                        'lng' => (float) $c->longitude,
                        'time' => $c->created_at->format('d/m/Y H:i')
                    ];
                }));

                const map = L.map('checkinMap');

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                const bounds = [];
                const points = [];

                $.each(checkinData, function (index, point) {
                    const marker = L.marker([point.lat, point.lng]).addTo(map);
                    marker.bindPopup(`<b>Check-in #${checkinData.length - index}</b><br>${point.time}`);
                    bounds.push([point.lat, point.lng]);
                    points.push([point.lat, point.lng]);
                });

                if (points.length > 1) {
                    L.polyline(points, { color: 'blue' }).addTo(map);
                }

                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }

            @endif
                            });
    </script>
@endsection