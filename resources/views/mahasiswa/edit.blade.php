
@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
    <x-page-header
        judul="Edit Mahasiswa"
        deskripsi="Perbarui informasi data mahasiswa."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim"
                        class="form-control @error('nim') is-invalid @enderror"
                        value="{{ old('nim', $mahasiswa->nim) }}">

                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $mahasiswa->nama) }}">

                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $mahasiswa->email) }}">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Angkatan</label>
                    <input type="number" name="angkatan"
                        class="form-control @error('angkatan') is-invalid @enderror"
                        value="{{ old('angkatan', $mahasiswa->angkatan) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="program_studi"
                        class="form-control @error('program_studi') is-invalid @enderror"
                        value="{{ old('program_studi', $mahasiswa->program_studi) }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('mahasiswa.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
