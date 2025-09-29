@extends('layouts.maxton')
@section('title', 'Importar Entrega por PDF com Gemini')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Entrega | Importar PDF</h4>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Upload de DAMDFE</h5>

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('entregas.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="pdf_file" class="form-label">Selecione o ficheiro PDF</label>
                                    <input class="form-control" type="file" id="pdf_file" name="pdf_file" accept=".pdf"
                                        required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Importar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection