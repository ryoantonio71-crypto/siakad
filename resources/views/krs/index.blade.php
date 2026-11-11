
@extends('layouts.app')

@section('title', 'Data KRS')

@section('content')
    <x-page-header
        judul="Data KRS"
        deskripsi="Daftar Kartu Rencana Studi mahasiswa."
    />

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Daftar Kartu Rencana Studi</span>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('krs.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah KRS
                </a>
            @endif
        </div>

        <div class="card-body">

            {{-- Form Filter --}}
            <form action="{{ route('krs.index') }}" method="GET" class="row g-2 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Tahun Akademik</label>
                    <select name="tahun_akademik" class="form-select">
                        <option value="">Semua Tahun Akademik</option>

                        @foreach ($tahunAkademik as $tahun)
                            <option value="{{ $tahun }}"
                                {{ request('tahun_akademik') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="">Semua Semester</option>
                        <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>
                            Ganjil
                        </option>
                        <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>
                            Genap
                        </option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Terapkan Filter
                    </button>

                    <a href="{{ route('krs.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">Tahun Akademik</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($krs as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $item->mahasiswa->nama ?? '-' }}
                                    </div>
                                    <small class="text-muted">
                                        NIM: {{ $item->mahasiswa->nim ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    @forelse ($item->mataKuliah as $mk)
                                        <div class="mb-1">
                                            <span class="badge bg-secondary">
                                                {{ $mk->kode_mk }}
                                            </span>
                                            {{ $mk->nama_mk }}
                                        </div>
                                    @empty
                                        <span class="text-muted">Belum ada mata kuliah</span>
                                    @endforelse
                                </td>

                                <td class="text-center">
                                    {{ $item->tahun_akademik }}
                                </td>

                                <td class="text-center">
                                    {{ $item->semester }}
                                </td>

                                <td class="text-center">
                                    @if ($item->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($item->status === 'diajukan')
                                        <span class="badge bg-warning text-dark">Diajukan</span>
                                    @elseif ($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('krs.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-hapus-krs"
                                            data-url="{{ route('krs.destroy', $item->id) }}"
                                            data-nama="{{ $item->mahasiswa->nama ?? 'Mahasiswa' }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada data KRS yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>

<script>
    const csrfToken = @json(csrf_token());

    $(document).on('click', '.btn-hapus-krs', function () {
        const url = this.dataset.url;
        const nama = this.dataset.nama;

        Swal.fire({
            title: 'Hapus KRS?',
            text: 'KRS milik ' + nama + ' akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545'
        }).then(function (hasil) {
            if (!hasil.isConfirmed) return;

            $.ajax({
                url: url,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            }).done(function (respons) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: respons.message
                }).then(function () {
                    location.reload();
                });
            }).fail(function (xhr) {
                const pesan = xhr.responseJSON?.message || 'Data gagal dihapus.';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: pesan
                });
            });
        });
    });
</script>
@endpush
