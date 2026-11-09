<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIPALA') - Sistem Informasi Peminjaman Alat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='82'>⚙</text></svg>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">
    @stack('styles')

    <style>
        .notif-dot {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 8px;
            height: 8px;
            background: #dc3545;
            border-radius: 50%;
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                background-color: #f8f9fa !important;
                z-index: 1040 !important;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                display: block !important;
            }

            .sidebar-open .app-sidebar {
                transform: translateX(0);
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            }

            .sidebar-open .app-main {
                filter: blur(2px);
                pointer-events: none;
            }
        }

        .sidebar-mini.sidebar-collapse .nav-link p {
            display: none;
        }

        body:not(.sidebar-collapse) .nav-link[data-lte-toggle="sidebar"] {
            background-color: #e2e2e2 !important;
            color: #000 !important;
            border-radius: 2px;
        }

        .nav-link[data-lte-toggle="sidebar"]:hover {
            background-color: #f0f0f0 !important;
            border-radius: 2px;
        }

        body.sidebar-collapse .app-sidebar:not(:hover) .sidebar-brand .brand-link {
            justify-content: center !important;
            padding: 0 !important;
        }

        body.sidebar-collapse .app-sidebar:not(:hover) .brand-text {
            display: none !important;
        }

        .sidebar-brand .brand-link {
            min-height: 65px;
        }

        /* Styling Global Pagination Mini & Rapi */
        .pagination-sm .page-link {
            padding: 4px 10px !important;
            font-size: 0.875rem !important;
            color: #6c757d;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .pagination-sm .page-item {
            margin: 0 2px !important;
        }

        .pagination-sm nav>div:first-child,
        .pagination-sm nav p {
            display: none !important;
        }

        .pagination-sm nav {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini">
    <div class="app-wrapper">
        {{-- ================= NAVBAR ================= --}}
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    {{-- Toggle Sidebar --}}
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">

                            <i class="bi bi-list"></i>
                        </a>
                    </li>

                    {{-- Dashboard --}}
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            Dashboard
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    {{-- Tanggal dan Jam --}}
                    <li class="nav-item d-none d-md-flex align-items-center px-2">
                        <div class="text-end text-muted small lh-sm">
                            <div>
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>
                            <div>
                                <i class="bi bi-clock me-1"></i>
                                <span id="liveClock">00:00:00</span>
                            </div>
                        </div>
                    </li>

                    {{-- Divider --}}
                    <li class="nav-item d-none d-md-block">
                        <span class="text-muted">|</span>
                    </li>

                    {{-- Fullscreen --}}
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link px-2" href="#" data-lte-toggle="fullscreen" title="Fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>

                    {{-- Informasi Pengguna --}}
                    @php
                        $user = Auth::guard('web')->user();
                        $name = $user->nama;
                        $role = $user->role ?? '';
                        $inisial = collect(explode(' ', $name))
                            ->filter()
                            ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                            ->take(2)
                            ->join('');
                        $roleColors = [
                            'super_admin' => 'bg-danger',
                            'admin' => 'bg-primary',
                        ];

                        $colorClass = $roleColors[$role] ?? 'bg-secondary';
                        $roleNames = [
                            'super_admin' => 'Super Admin',
                            'admin' => 'Admin',
                        ];
                    @endphp

                    {{-- Dropdown Akun --}}
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center gap-2 px-2"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            <div class="d-flex align-items-center justify-content-center rounded-circle
                                {{ $colorClass }} text-white fw-bold shadow-sm"
                                style="width:32px;height:32px;font-size:13px;">
                                {{ $inisial }}
                            </div>
                            <i class="bi bi-chevron-down text-muted small"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 p-0"
                            style="min-width:240px">
                            {{-- Header Akun --}}
                            <li class="px-4 py-3 text-center border-bottom">
                                <div class="mx-auto mb-2 d-flex align-items-center justify-content-center
                                    rounded-circle {{ $colorClass }} text-white fw-bold shadow"
                                    style="width:70px;height:70px;font-size:24px;">
                                    {{ $inisial }}
                                </div>
                                <div class="fw-semibold text-dark">
                                    {{ $name }}
                                </div>
                                <div class="small text-muted mt-1">
                                    {{ $roleNames[$role] ?? 'Pengguna' }}
                                </div>
                            </li>
                            {{-- Pengaturan Akun --}}
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                                    <i class="bi bi-person-circle text-primary"></i>
                                    <span>Profil Saya</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                                    <i class="bi bi-gear text-secondary"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>

                            {{-- Logout --}}
                            <li>
                                <button id="btnLogout" type="button"
                                    class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Keluar</span>
                                </button>
                                <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- ================= SIDEBAR ================= --}}
        <aside class="app-sidebar bg-body-light shadow" data-bs-theme="light">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <a href="#" class="brand-link text-decoration-none d-flex align-items-center gap-2">
                    <i class="bi bi-tools text-primary" style="font-size: 30px;"></i>
                    <span class="brand-text fw-semibold text-dark" style="letter-spacing:1px;font-size:0.90rem;">
                        SIPALA
                    </span>
                </a>
            </div>

            {{-- Sidebar Menu --}}
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        {{-- UTAMA --}}
                        <li class="nav-header">
                            UTAMA
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        {{-- MASTER DATA --}}
                        <li class="nav-header">
                            MASTER DATA
                        </li>

                        <li
                            class="nav-item
                            {{ request()->routeIs('admin.kategori-alat.*', 'admin.alat.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link
                                {{ request()->routeIs('admin.kategori-alat.*', 'admin.alat.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-database"></i>
                                <p>
                                    Data Master
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                {{-- Data Teknisi --}}
                                <li class="nav-item">
                                    <a href="{{ route('masterdata.teknisi.index') }}" class="nav-link"
                                        data-pin-access data-pin-feature="teknisi">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Kelola Teknisi</p>
                                    </a>
                                </li>

                                {{-- Data Alat --}}
                                <li class="nav-item">
                                    <a href="{{ route('masterdata.alat.index') }}" class="nav-link" data-pin-access
                                        data-pin-feature="alat">
                                        <i class="nav-icon fas fa-tools"></i>
                                        <p>Kelola Alat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- TTRANSAKSI --}}
                        <li class="nav-header">
                            TRANSAKSI
                        </li>
                        <li
                            class="nav-item
                            {{ request()->routeIs('transaksi.peminjaman.*', 'transaksi.pengembalian.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link
                                {{ request()->routeIs('transaksi.peminjaman.*', 'transaksi.pengembalian.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-arrow-left-right"></i>
                                <p>
                                    Transaksi Peminjaman
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                {{-- Peminjaman Alat --}}
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.peminjaman.index') }}"
                                        class="nav-link {{ request()->routeIs('transaksi.peminjaman.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-box-arrow-up"></i>
                                        <p>Peminjaman Alat</p>
                                    </a>
                                </li>

                                {{-- Pengembalian --}}
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.pengembalian.index') }}"
                                        class="nav-link {{ request()->routeIs('transaksi.pengembalian.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-box-arrow-in-down"></i>
                                        <p>Pengembalian Alat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Riwayat --}}
                        <li class="nav-header">
                            RIWAYAT
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('riwayat.riwayat-transaksi.index') }}"
                                class="nav-link {{ request()->routeIs('riwayat.riwayat-transaksi.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-clock-history"></i>
                                <p>Riwayat Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="app-main">

            {{-- Content Header --}}
            <div class="app-content-header">
                <div class="container-fluid">
                    @hasSection('page-title')
                        <h3 class="mb-0">
                            @yield('page-title')
                        </h3>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>

                {{-- Toast Success --}}
                @if (session('success'))
                    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">

                        <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 shadow"
                            role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Toast Error --}}
                @if (session('error'))
                    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
                        <div id="toastError" class="toast align-items-center text-bg-danger border-0 shadow"
                            role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>



        {{-- MODAL VERIFIKASI PIN --}}
        <div class="modal fade" id="modalVerifikasiPin" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 360px;">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center
                                bg-primary bg-opacity-10 rounded-circle"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-lock text-primary" style="font-size: 23px;"></i>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-1">
                            Verifikasi PIN
                        </h5>

                        <p class="text-muted small mb-4">
                            Masukkan PIN Verifikasi untuk mengakses fitur.
                        </p>
                        <form id="formVerifikasiPin" method="POST" action="{{ route('pin.verify') }}">
                            @csrf
                            <input type="hidden" name="feature" id="pinFeature">
                            <div class="mb-3">
                                <input type="password" name="pin" id="inputPin"
                                    class="form-control text-center" placeholder="Masukkan 6 digit PIN"
                                    inputmode="numeric" pattern="[0-9]{6}" minlength="6" maxlength="6" required
                                    autocomplete="off">
                            </div>
                            <div id="pinError" class="text-danger small mb-3 d-none">
                                PIN yang Anda masukkan salah.
                                Silakan hubungi DEVMP.
                            </div>
                            <button type="submit" id="btnVerifikasiPin" class="btn btn-primary w-100" disabled>
                                Verifikasi PIN
                            </button>
                            <button type="button" class="btn btn-light w-100 rounded-3 mt-2"
                                data-bs-dismiss="modal">
                                Batal
                            </button>
                        </form>
                        <div class="border-top mt-3 pt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Protected by DEVMP Solutions.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL AKSES DITOLAK --}}
        <div class="modal fade" id="modalPinError" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 360px;">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center
                                bg-danger bg-opacity-10 rounded-circle"
                                style="width: 65px; height: 65px;">
                                <i class="fas fa-shield-alt text-danger" style="font-size: 27px;"></i>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-2">
                            PIN Tidak Valid!
                        </h5>

                        <p class="text-muted small">
                            PIN yang Anda masukkan salah. Silakan coba kembali.
                        </p>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            <i class="fas fa-headset text-primary mb-2" style="font-size: 24px;"></i>
                            <div class="fw-bold">
                                Lupa PIN?
                            </div>
                            <small class="text-muted">
                                Hubungi DEVMP Solutions untuk mendapatkan bantuan akses.
                            </small>
                        </div>

                        <button type="button" class="btn btn-danger w-100 rounded-3" data-bs-dismiss="modal">
                            Mengerti
                        </button>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Protected by DEVMP Solutions.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FOOTER ================= --}}
        <footer class="app-footer border-top small text-muted py-2">
            <div
                class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-center text-md-start">
                <span>
                    &copy; {{ date('Y') }}
                    <strong>Sistem Informasi Peminjaman Alat (SIPALA).</strong>
                </span>
                
                <span>
                    Developed by <strong>DEVMP Solutions.</strong>
                </span>
            </div>
        </footer>

        {{-- ================= JAVASCRIPT ================= --}}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js">
        </script>
        <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

        <script>
            // ================= JAM DIGITAL =================
            function updateClock() {
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const s = String(now.getSeconds()).padStart(2, '0');
                const clockElement = document.getElementById('liveClock');
                if (clockElement) {
                    clockElement.textContent = `${h}:${m}:${s}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // ================= SIDEBAR =================
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            document.addEventListener('DOMContentLoaded', function() {
                const body = document.body;
                const btnToggle = document.querySelector(
                    '[data-lte-toggle="sidebar"]'
                );

                // Status sidebar
                const sidebarStatus = localStorage.getItem('sidebar-locked');
                if (window.innerWidth >= 992) {
                    if (sidebarStatus === 'true') {
                        body.classList.remove('sidebar-collapse');
                    } else {
                        body.classList.add('sidebar-collapse');
                    }
                }

                // Toggle sidebar
                if (btnToggle) {
                    btnToggle.addEventListener('click', function() {
                        setTimeout(() => {
                            if (window.innerWidth >= 992) {
                                const isCollapsed =
                                    body.classList.contains('sidebar-collapse');
                                localStorage.setItem(
                                    'sidebar-locked',
                                    isCollapsed ? 'false' : 'true'
                                );
                            }
                        }, 100);
                    });
                }

                // Overlay Scrollbar
                const sidebarWrapper = document.querySelector(
                    SELECTOR_SIDEBAR_WRAPPER
                );

                if (
                    sidebarWrapper &&
                    typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined'
                ) {

                    OverlayScrollbarsGlobal.OverlayScrollbars(
                        sidebarWrapper, {
                            scrollbars: {
                                theme: 'os-theme-light',
                                autoHide: 'leave',
                                clickScroll: true,
                            },
                        }
                    );
                }

                // Close sidebar setelah menu dipilih di mobile
                document.querySelectorAll(
                    '.sidebar-wrapper .nav-link'
                ).forEach(link => {

                    link.addEventListener('click', () => {
                        if (
                            window.innerWidth < 992 &&
                            body.classList.contains('sidebar-open')
                        ) {
                            btnToggle?.click();
                        }
                    });
                });

                // Klik di luar sidebar
                document.addEventListener('click', function(event) {
                    const sidebar = document.querySelector('.app-sidebar');
                    if (
                        window.innerWidth < 992 &&
                        body.classList.contains('sidebar-open') &&
                        sidebar &&
                        !sidebar.contains(event.target) &&
                        !btnToggle?.contains(event.target)
                    ) {

                        body.classList.remove('sidebar-open');
                        body.classList.add('sidebar-closed');
                    }
                });

                // ================= LOGOUT =================

                const btnLogout = document.getElementById('btnLogout');
                if (btnLogout) {
                    btnLogout.addEventListener('click', function() {
                        Swal.fire({
                            title: 'Keluar',
                            text: 'Apakah Anda yakin ingin keluar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, keluar',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logoutForm').submit();
                            }
                        });
                    });
                }

                // ================= DELETE CONFIRMATION =================
                document.querySelectorAll('.form-delete').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const name = form.dataset.name ?? 'data ini';
                        const title = form.dataset.title ?? 'Konfirmasi Hapus';
                        const text = form.dataset.text ?? 'Yakin ingin menghapus data ini?';

                        Swal.fire({
                            title: title,
                            html: `${text}<br><strong>${name}</strong>`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                // ================= TOAST =================
                const toastSuccess = document.getElementById('toastSuccess');
                if (toastSuccess) {
                    new bootstrap.Toast(toastSuccess, {
                        delay: 3000
                    }).show();
                }

                const toastError = document.getElementById('toastError');
                if (toastError) {
                    new bootstrap.Toast(toastError, {
                        delay: 3000
                    }).show();
                }
            });

            // ================= LOADING OVERLAY =================
            function showLoading() {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            }

            function hideLoading() {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) {
                    overlay.style.display = 'none';
                }
            }

            // AKSES PIN
            document.addEventListener('DOMContentLoaded', function() {
                const modalElement = document.getElementById('modalVerifikasiPin');
                const modalPin = new bootstrap.Modal(modalElement);
                const inputPin = document.getElementById('inputPin');
                const pinError = document.getElementById('pinError');
                // Buka modal ketika tombol master data diklik
                document.querySelectorAll('[data-pin-access]').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('pinRedirect').value =
                            this.getAttribute('href');
                        inputPin.value = '';
                        pinError.classList.add('d-none');
                        modalPin.show();
                        modalElement.addEventListener('shown.bs.modal', function() {
                            inputPin.focus();
                        }, {
                            once: true
                        });
                    });
                });
                inputPin.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 6);
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const modalPinElement = document.getElementById('modalVerifikasiPin');
                if (!modalPinElement) return;
                const modalPin = new bootstrap.Modal(modalPinElement);
                const inputPin = document.getElementById('inputPin');
                const pinError = document.getElementById('pinError');
                document.querySelectorAll('[data-pin-access]').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const feature = this.dataset.pinFeature;
                        document.getElementById('pinFeature').value = feature;
                        inputPin.value = '';
                        if (pinError) {
                            pinError.classList.add('d-none');
                        }
                        modalPin.show();
                    });
                });
                inputPin.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 6);
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('formVerifikasiPin');
                const inputPin = document.getElementById('inputPin');
                const btnSubmit = document.getElementById('btnVerifikasiPin');

                if (!form || !inputPin || !btnSubmit) return;

                // Hanya menerima angka maksimal 6 digit
                inputPin.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 6);

                    // Tombol aktif hanya jika 6 digit
                    btnSubmit.disabled = this.value.length !== 6;
                });

                // Cegah submit jika PIN belum lengkap
                form.addEventListener('submit', function(e) {
                    if (inputPin.value.length !== 6) {
                        e.preventDefault();
                        inputPin.focus();
                        btnSubmit.disabled = true;
                    }
                });
            });
        </script>

        @stack('scripts')

</body>

</html>

@if (session('pin_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalPinError');
            if (!modalElement) return;
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    </script>
@endif
