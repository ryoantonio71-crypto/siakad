
@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')

@section('content')
    <x-page-header
        judul="Detail Mata Kuliah"
        deskripsi="Informasi lengkap mata kuliah."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body fw-semibold">
            Informasi Mata Kuliah
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="180">Kode Mata Kuliah</th>
                    <td>: {{ $matakuliah->kode_mk }}</td>
                </tr>
                <tr>
                    <th>Nama Mata Kuliah</th>
                    <td>: {{ $matakuliah->nama_mk }}</td>
                </tr>
                <tr>
                    <th>SKS</th>
                    <td>: {{ $matakuliah->sks }}</td>
                </tr>
            </table>

            <a href="{{ route('matakuliah.index') }}"
                class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('matakuliah.edit', $matakuliah->id) }}"
                    class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            @endif
        </div>
    </div>
@endsection
