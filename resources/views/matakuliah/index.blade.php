
@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
    <x-page-header
        judul="Data Mata Kuliah"
        deskripsi="Daftar seluruh mata kuliah yang tersedia."
    >
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
            </a>
        @endif
    </x-page-header>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body fw-semibold">
            Daftar Mata Kuliah
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matakuliah as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>
                                    <a href="{{ route('matakuliah.show', $mk->id) }}"
                                        class="btn btn-sm btn-info"
                                        title="Detail Mata Kuliah">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('matakuliah.edit', $mk->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-hapus-mk"
                                            data-url="{{ route('matakuliah.destroy', $mk->id) }}"
                                            data-nama="{{ $mk->nama_mk }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data mata kuliah.
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

    $(document).on('click', '.btn-hapus-mk', function () {
        const url = this.dataset.url;
        const nama = this.dataset.nama;

        Swal.fire({
            title: 'Hapus Mata Kuliah?',
            text: 'Data ' + nama + ' akan dihapus permanen.',
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
