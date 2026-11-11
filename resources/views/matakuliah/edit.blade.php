
@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
    <x-page-header
        judul="Edit Mata Kuliah"
        deskripsi="Perbarui informasi mata kuliah."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('matakuliah.update', $matakuliah->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Mata Kuliah</label>
                    <input type="text" name="kode_mk"
                        class="form-control @error('kode_mk') is-invalid @enderror"
                        value="{{ old('kode_mk', $matakuliah->kode_mk) }}">

                    @error('kode_mk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk"
                        class="form-control @error('nama_mk') is-invalid @enderror"
                        value="{{ old('nama_mk', $matakuliah->nama_mk) }}">

                    @error('nama_mk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" name="sks"
                        class="form-control @error('sks') is-invalid @enderror"
                        value="{{ old('sks', $matakuliah->sks) }}">

                    @error('sks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('matakuliah.index') }}"
                    class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
