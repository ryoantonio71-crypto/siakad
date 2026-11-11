
@extends('layouts.app')

@section('title', 'Edit KRS')

@section('content')
    <x-page-header
        judul="Edit KRS"
        deskripsi="Perbarui data Kartu Rencana Studi."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('krs.update', $krs->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-select">
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}"
                                {{ old('mahasiswa_id', $krs->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mata Kuliah</label>
                    <select name="mata_kuliah_id" class="form-select">
                        @foreach ($matakuliah as $mk)
                            <option value="{{ $mk->id }}"
                                {{ old('mata_kuliah_id', $krs->mataKuliah->first()?->id) == $mk->id ? 'selected' : '' }}>
                                {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                            </option>
                        @endforeach
                    </select>
                    @error('mata_kuliah_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik"
                        class="form-control"
                        value="{{ old('tahun_akademik', $krs->tahun_akademik) }}">
                    @error('tahun_akademik')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="Ganjil" {{ old('semester', $krs->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester', $krs->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('krs.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
