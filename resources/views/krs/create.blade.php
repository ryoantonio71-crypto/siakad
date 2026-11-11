
@extends('layouts.app')

@section('title', 'Tambah KRS')

@section('content')
    <x-page-header
        judul="Tambah KRS"
        deskripsi="Buat Kartu Rencana Studi mahasiswa."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('krs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id"
                        class="form-select @error('mahasiswa_id') is-invalid @enderror">
                        <option value="">Pilih Mahasiswa</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}"
                                {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mata Kuliah</label>
                    <select name="mata_kuliah_id"
                        class="form-select @error('mata_kuliah_id') is-invalid @enderror">
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach ($matakuliah as $mk)
                            <option value="{{ $mk->id }}"
                                {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                            </option>
                        @endforeach
                    </select>
                    @error('mata_kuliah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik"
                        class="form-control @error('tahun_akademik') is-invalid @enderror"
                        placeholder="Contoh: 2026/2027"
                        value="{{ old('tahun_akademik') }}">
                    @error('tahun_akademik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester"
                        class="form-select @error('semester') is-invalid @enderror">
                        <option value="">Pilih Semester</option>
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="{{ route('krs.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
