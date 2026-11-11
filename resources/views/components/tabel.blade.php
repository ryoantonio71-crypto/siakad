
@props([
    'kolom' => [],
    'baris' => [],
    'aksi' => false,
])

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px">#</th>

                @foreach ($kolom as $judul)
                    <th scope="col">{{ $judul }}</th>
                @endforeach

                @if ($aksi)
                    <th scope="col" style="width: 150px">Aksi</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @forelse ($baris as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    @foreach ($kolom as $kunci => $judul)
                        <td>
                            @if ($kunci === 'status')
                                @php
                                    $warna = match ($item[$kunci]) {
                                        'Aktif', 'Disetujui' => 'success',
                                        'Menunggu', 'Cuti' => 'warning',
                                        'Ditolak' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge text-bg-{{ $warna }}">
                                    {{ $item[$kunci] }}
                                </span>
                            @else
                                {{ $item[$kunci] }}
                            @endif
                        </td>
                    @endforeach

                    @if ($aksi)
                        <td>
                            <a href="{{ route('mahasiswa.show', $item['id']) }}"
                                class="btn btn-sm btn-info"
                                title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('mahasiswa.edit', $item['id']) }}"
                                class="btn btn-sm btn-warning"
                                title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('mahasiswa.destroy', $item['id']) }}"
                                method="POST" class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($kolom) + ($aksi ? 2 : 1) }}"
                        class="text-center text-body-secondary py-4">
                        Belum Ada Data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($aksi)
    @push('scripts')
        <script>
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data mahasiswa yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
