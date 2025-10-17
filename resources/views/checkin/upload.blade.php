@extends('layouts.maxton')
@section('title', 'Check-in de Entrega')

@section('styles')
    <style>
        .camera-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 90%;
            height: 45%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.55);
        }

        .overlay::before,
        .overlay::after {
            content: "";
            position: absolute;
            width: 25px;
            height: 25px;
            border: 3px solid var(--overlay-color, #00ff00);
            transition: border-color 0.3s ease;
        }

        .overlay::before {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
        }

        .overlay::after {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
        }

        .preview-container img {
            width: 100%;
            border-radius: 10px;
        }

        .doc-card img {
            max-width: 100%;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .doc-card img:hover {
            transform: scale(1.05);
        }

        .doc-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Entrega #{{ $entrega->id }}</div>
                <div class="ps-3">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('entregas.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Check-in de Documento</li>
                    </ol>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h4 class="mb-3">Capturar Documento de Entrega</h4>
                    <button id="openCamera" class="btn btn-primary">📷 Abrir Câmera</button>
                </div>
            </div>

            {{-- Lista de documentos --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">📄 Documentos enviados</h5>
                    @if ($documentos->count() > 0)
                        <div class="row g-3">
                            @foreach ($documentos as $doc)
                                <div class="col-md-4">
                                    <div class="doc-card text-center">
                                        <img src="{{ asset('storage/' . $doc->arquivo) }}" alt="Documento" data-bs-toggle="modal"
                                            data-bs-target="#previewModal{{ $doc->id }}">
                                        <p class="mt-2 mb-0 text-muted small">
                                            {{ $doc->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Modal de preview -->
                                <div class="modal fade" id="previewModal{{ $doc->id }}" tabindex="-1"
                                    aria-labelledby="previewModalLabel{{ $doc->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content bg-dark text-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Documento #{{ $doc->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                    aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ $doc->url }}" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Nenhum documento enviado ainda.</p>
                    @endif
                </div>
            </div>

            <canvas id="snapshot" class="d-none"></canvas>
        </div>
    </main>

    <!-- Modal da Câmera -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Enquadre o documento dentro da área verde</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <div class="camera-container mx-auto position-relative" style="width: 360px; height: 480px;">
                        <video id="camera" autoplay playsinline></video>
                        <div class="overlay"></div>
                    </div>
                    <div id="previewArea" class="preview-container d-none mt-3">
                        <img id="previewImage" alt="Prévia do Documento">
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="capture" class="btn btn-success">📸 Capturar</button>
                    <button id="retake" class="btn btn-warning d-none">🔄 Refazer</button>
                    <button id="confirmUpload" class="btn btn-primary d-none">✅ Confirmar</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script async src="https://docs.opencv.org/4.8.0/opencv.js"></script>
    <script>
        let stream;
        let detectando = false;
        const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
        const video = document.getElementById('camera');
        const canvas = document.getElementById('snapshot');
        const overlay = document.querySelector('.overlay');
        const captureBtn = document.getElementById('capture');
        const retakeBtn = document.getElementById('retake');
        const confirmBtn = document.getElementById('confirmUpload');
        const previewArea = document.getElementById('previewArea');
        const previewImage = document.getElementById('previewImage');


        document.getElementById('openCamera').onclick = async () => {
            modal.show();
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                video.srcObject = stream;


                video.onloadedmetadata = () => {
                    video.play();
                    startDetectionLoop();
                };
            } catch (err) {
                alert("Erro ao acessar câmera: " + err.message);
            }
        };


        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', () => {
            if (stream) stream.getTracks().forEach(track => track.stop());
            detectando = false;
            previewArea.classList.add('d-none');
            captureBtn.classList.remove('d-none');
            confirmBtn.classList.add('d-none');
            retakeBtn.classList.add('d-none');
        });


        function calcularBrilhoMedio(canvas) {
            const ctx = canvas.getContext('2d');
            const data = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            let total = 0;
            for (let i = 0; i < data.length; i += 4)
                total += (data[i] + data[i + 1] + data[i + 2]) / 3;
            return total / (data.length / 4);
        }

        function calcularNitidez(canvas) {
            const cv = window.cv;
            const src = cv.imread(canvas);
            const gray = new cv.Mat();
            cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY);
            const laplacian = new cv.Mat();
            cv.Laplacian(gray, laplacian, cv.CV_64F);
            const mean = new cv.Mat();
            const stddev = new cv.Mat();
            cv.meanStdDev(laplacian, mean, stddev);
            const variance = Math.pow(stddev.doubleAt(0, 0), 2);
            src.delete(); gray.delete(); laplacian.delete(); mean.delete(); stddev.delete();
            return variance;
        }

        function detectarDocumento(canvas) {
            const cv = window.cv;
            const src = cv.imread(canvas);
            const gray = new cv.Mat();
            cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY);
            cv.GaussianBlur(gray, gray, new cv.Size(5, 5), 0);

            const edges = new cv.Mat();
            cv.Canny(gray, edges, 75, 200);

            const contours = new cv.MatVector();
            const hierarchy = new cv.Mat();
            cv.findContours(edges, contours, hierarchy, cv.RETR_LIST, cv.CHAIN_APPROX_SIMPLE);

            let found = false;
            let maxArea = 0;
            for (let i = 0; i < contours.size(); i++) {
                const cnt = contours.get(i);
                const peri = cv.arcLength(cnt, true);
                const approx = new cv.Mat();
                cv.approxPolyDP(cnt, approx, 0.02 * peri, true);
                const area = cv.contourArea(cnt);

                if (approx.rows === 4 && area > maxArea && area > 5000) {
                    found = true;
                    maxArea = area;
                }
            }

            src.delete(); gray.delete(); edges.delete(); contours.delete(); hierarchy.delete();
            return found;
        }


        function startDetectionLoop() {
            if (!window.cv || !window.cv.imread) {
                setTimeout(startDetectionLoop, 500);
                return;
            }

            detectando = true;
            const tempCanvas = document.createElement('canvas');
            const ctx = tempCanvas.getContext('2d');

            const loop = () => {
                if (!detectando) return;
                tempCanvas.width = video.videoWidth;
                tempCanvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0, tempCanvas.width, tempCanvas.height);

                const documentoDetectado = detectarDocumento(tempCanvas);

                // overlay.style.border = documentoDetectado ? '3px solid #00ff00' : '3px solid #ff0000';
                // overlay.style.boxShadow = documentoDetectado
                //     ? '0 0 15px rgba(0,255,0,0.8)'
                //     : '0 0 15px rgba(255,0,0,0.8)';
                overlay.style.setProperty('--overlay-color', documentoDetectado ? '#00ff00' : '#ff0000');

                requestAnimationFrame(loop);
            };

            loop();
        }


        captureBtn.onclick = async () => {
            if (!window.cv || !window.cv.imread) {
                alert('OpenCV ainda carregando, tente novamente.');
                return;
            }

            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);

            const brilho = calcularBrilhoMedio(canvas);
            const nitidez = calcularNitidez(canvas);

            // if (brilho < 50) return alert('Imagem muito escura! Tente novamente.');
            if (brilho > 220) return alert('Imagem muito clara! Evite luz direta.');
            if (nitidez < 100) return alert('Imagem desfocada! Mantenha firme e tente novamente.');

            previewImage.src = canvas.toDataURL('image/jpeg', 0.9);
            previewArea.classList.remove('d-none');
            captureBtn.classList.add('d-none');
            confirmBtn.classList.remove('d-none');
            retakeBtn.classList.remove('d-none');
        };

        retakeBtn.onclick = () => {
            previewArea.classList.add('d-none');
            captureBtn.classList.remove('d-none');
            confirmBtn.classList.add('d-none');
            retakeBtn.classList.add('d-none');
        };

        confirmBtn.onclick = async () => {
            const dataUrl = previewImage.src;
            confirmBtn.disabled = true;
            confirmBtn.textContent = '⏳ Enviando...';

            await fetch(`{{ route('checkin.documento.upload', $entrega->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image: dataUrl })
            })
                .then(r => r.json())
                .then(res => {
                    alert(res.message);
                    location.reload();
                    modal.hide();
                })
                .catch(err => alert('Erro ao enviar imagem: ' + err.message))
                .finally(() => {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = '✅ Confirmar';
                });
        };
    </script>
@endsection