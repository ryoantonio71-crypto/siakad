@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-sm text-center mx-auto"
             style="max-width: 600px;">
            <div class="card-body p-5">

                <h1 class="display-1 fw-bold text-danger">403</h1>

                <h2 class="h4 fw-bold mb-3">Akses Ditolak</h2>

                <p class="text-body-secondary mb-4">
                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                </p>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-primary">
                    <i class="bi bi-house-door-fill me-2"></i>
                    Kembali ke Dashboard
                </a>

            </div>
        </div>
    </div>
@endsection