
@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <x-page-header
        judul="Tambah Mahasiswa"
        deskripsi="Tambahkan data mahasiswa baru."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('mahasiswa.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim"
                        class="form-control @error('nim') is-invalid @enderror"
                        value="{{ old('nim') }}">

                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}">

                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Angkatan</label>
                    <input type="number" name="angkatan"
                        class="form-control @error('angkatan') is-invalid @enderror"
                        value="{{ old('angkatan') }}">

                    @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="program_studi"
                        class="form-control @error('program_studi') is-invalid @enderror"
                        value="{{ old('program_studi') }}">

                    @error('program_studi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('mahasiswa.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
