@push('scripts')
    @foreach (['success', 'error', 'warning', 'info'] as $kunci)
        @if (session($kunci))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: @json($kunci === 'error' ? 'error' : $kunci),
                    title: @json(session($kunci)),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>
        @endif
    @endforeach
@endpush