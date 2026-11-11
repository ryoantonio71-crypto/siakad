
@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
    <x-page-header
        judul="Detail Mahasiswa"
        deskripsi="Informasi lengkap mahasiswa."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body fw-semibold">
            Informasi Mahasiswa
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="180">NIM</th>
                    <td>: {{ $mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>: {{ $mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>: {{ $mahasiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>: {{ $mahasiswa->email }}</td>
                </tr>
                <tr>
                    <th>Angkatan</th>
                    <td>: {{ $mahasiswa->angkatan }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>: {{ $mahasiswa->program_studi }}</td>
                </tr>
            </table>

            <a href="{{ route('mahasiswa.index') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            @endif
        </div>
    </div>
@endsection
