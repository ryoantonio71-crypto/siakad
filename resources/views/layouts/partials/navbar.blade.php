
<nav class="navbar navbar-dark bg-success sticky-top shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none me-2" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-1"></i>
                {{ config('app.name') }}
            </a>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="button" id="themeToggle"
                    class="btn btn-outline-light btn-sm">
                <i class="bi bi-moon-stars-fill"></i>
                <span class="d-none d-sm-inline">Ganti Tema</span>
            </button>

            <div class="dropdown">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text small">
                                {{ Auth::user()->email }}
                                <span class="badge text-bg-secondary ms-1">{{ Auth::user()->role }}</span>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>  
</nav>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tombol = document.getElementById('themeToggle');
        const html = document.documentElement;

        if (!tombol) return;

        tombol.addEventListener('click', function () {
            const temaSekarang = html.getAttribute('data-bs-theme');
            const temaBaru = temaSekarang === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-bs-theme', temaBaru);

            tombol.innerHTML = temaBaru === 'dark'
                ? '<i class="bi bi-sun-fill"></i> <span class="d-none d-sm-inline">Ganti Tema</span>'
                : '<i class="bi bi-moon-stars-fill"></i> <span class="d-none d-sm-inline">Ganti Tema</span>';
        });
    });
</script>
@endpush
