@extends('layouts.maxton')
@section('title', 'Importar Entrega por PDF com Gemini')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Entregas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('entregas.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Importar PDF</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-none d-md-block">
                    <a href="{{ route('entregas.create') }}" class="btn btn-primary">Nova Entrega</a>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Upload de DAMDFE</h5>

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="form-upload" action="{{ route('entregas.upload') }}" method="POST"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="pdf_file" class="form-label">Selecione o ficheiro PDF</label>
                                    <input class="form-control" type="file" id="pdf_file" name="pdf_file" accept=".pdf"
                                        required>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" id="btn-voltar" class="btn btn-secondary me-2">
                                        Voltar
                                    </button>
                                    <button type="submit" id="btn-importar" class="btn btn-primary">
                                        Importar
                                    </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form-upload');
            const btnImportar = document.getElementById('btn-importar');
            const btnVoltar = document.getElementById('btn-voltar');
            const fileInput = document.getElementById('pdf_file');

            // Ação do botão Voltar
            btnVoltar.addEventListener('click', function() {
                window.history.back();
                // Redireciona para a página de upload
                window.location.href = "{{ route('entregas.create') }}";
            });

            // Animação do botão Importar
            let animTimer = null;

            form.addEventListener('submit', function() {
                // Se não tiver arquivo, deixa a validação nativa atuar e não anima
                if (!fileInput.files || fileInput.files.length === 0) {
                    return;
                }

                // Evita múltiplos cliques
                if (btnImportar.dataset.animating === '1') return;
                btnImportar.dataset.animating = '1';

                // Desabilita apenas o botão (não mexe no input required)
                btnImportar.disabled = true;

                // Frames: ". .. ... . .. ..."
                const frames = ['Importando .', 'Importando ..', 'Importando ...', 'Importando .'];
                let i = 0;
                btnImportar.textContent = frames[i];

                animTimer = setInterval(() => {
                    i = (i + 1) % frames.length;
                    btnImportar.textContent = frames[i];
                }, 400);

                // Ao sair da página, limpa o timer
                window.addEventListener('beforeunload', () => clearInterval(animTimer), {
                    once: true
                });
            });
        });
    </script>
@endsection
