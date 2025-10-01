@extends('layouts.maxton')
@section('title', 'Realizar Check-in da Entrega')


@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #checkinMap {
            height: 50vh;

            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Entrega #{{ $entrega->id }}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Realizar Check-in</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center gap-3 text-center">
                                <i class="bi bi-geo-alt-fill fs-1 text-primary"></i>
                                <div>
                                    <h4 class="fw-bold mb-1">Check-in da Entrega</h4>
                                    <p>Olá, <strong>{{ $motorista->nome }}</strong>! Sua localização atual é mostrada no
                                        mapa abaixo. Pressione o botão para registrar sua posição.</p>
                                </div>

                                <div id="checkinMap" class="w-100 border mb-3"></div>

                                <div class="w-100">
                                    <button id="checkinBtn" class="btn btn-primary btn-lg w-100" disabled>
                                        Aguardando sinal do GPS...
                                    </button>
                                    <div id="status" class="mt-2 fw-bold"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>

        $(function () {
            console.log('Documento pronto. Script de check-in iniciado.');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            const $checkinBtn = $('#checkinBtn');
            const $statusDiv = $('#status');


            let userCoords = null;
            let map = null;

            if ($('#checkinMap').length) {
                console.log('Elemento do mapa encontrado. Inicializando Leaflet...');
                map = L.map('checkinMap').setView([-14.235, -51.925], 4);
            } else {
                console.error('ERRO: O elemento com ID "checkinMap" não foi encontrado no HTML.');
                return;
            }

            let marker = null;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);


            function onLocationFound(e) {
                userCoords = e.latlng;
                console.log('Localização encontrada:', userCoords);

                if ($checkinBtn.prop('disabled')) {
                    $checkinBtn.prop('disabled', false).html('Fazer Check-in Agora');
                    $statusDiv.text('Localização encontrada!').css('color', 'green');
                }

                if (marker) {
                    marker.setLatLng(userCoords);
                } else {
                    marker = L.marker(userCoords).addTo(map).bindPopup("Você está aqui.");
                    map.setView(userCoords, 16);
                }
            }

            function onLocationError(e) {
                console.error('Erro de geolocalização:', e.message);
                $checkinBtn.html('Erro de GPS').prop('disabled', true);
                $statusDiv.html('Não foi possível obter sua localização. Ative o GPS e dê permissão ao navegador.').css('color', 'red');
            }

            console.log('Solicitando localização do GPS...');
            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);
            map.locate({ watch: true, setView: false, enableHighAccuracy: true });


            $checkinBtn.on('click', function () {
                if (!userCoords) {
                    console.warn('Botão de check-in clicado, mas as coordenadas ainda não estão prontas.');
                    return;
                }


                $(this).prop('disabled', true).html('Enviando...');

                $.ajax({
                    url: '{{ route("checkin.store") }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        latitude: userCoords.lat,
                        longitude: userCoords.lng,
                        entregaHash: '{{ $entregaHash }}',
                        motoristaHash: '{{ $motoristaHash }}'
                    }),
                    success: function (response) {

                        $statusDiv.text(response.message).css('color', 'green');
                        $checkinBtn.html('<i class="bi bi-check-lg"></i> Check-in Realizado!')
                            .removeClass('btn-primary')
                            .addClass('btn-success');
                    },
                    error: function (xhr, status, error) {

                        $statusDiv.text('Erro ao enviar. Verifique o console para detalhes.').css('color', 'red');
                        $checkinBtn.prop('disabled', false).html('Tentar Novamente');
                    }
                });
            });
        });
    </script>
@endsection