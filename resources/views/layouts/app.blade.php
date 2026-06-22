@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Barcode</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background:#f4f6f9;
    }

    .sidebar{
        min-height:100vh;
        background:#1e3a8a;
    }

    .sidebar .nav-link{
        color:white;
        padding:12px;
        border-radius:10px;
        margin-bottom:5px;
    }

    .sidebar .nav-link:hover{
        background:rgba(255,255,255,.15);
    }

    .nav-link.active{
        background:#2563eb;
        font-weight:bold;
        color:white !important;
    }

    .content{
        padding:25px;
    }

    .logo-title{
        color:white;
        font-size:22px;
        font-weight:bold;
    }

    .role-badge{
        font-size:12px;
        background:#22c55e;
        padding:4px 10px;
        border-radius:20px;
        color:white;
    }

    .logo-title{
    color:white !important;
    font-size:22px;
    font-weight:bold;
    text-align:center;
    display:block;
}

.sidebar{
    background:#1e3a8a !important;
    color:white;
}

    @media(max-width:768px){
        .content{
            padding:10px;
        }

        h2{
            font-size:22px;
        }

        .table{
            font-size:12px;
        }
    }
</style>

</head>

<body>

<!-- Navbar HP -->

<nav class="navbar navbar-dark bg-primary d-md-none">
    <div class="container-fluid">

    <span class="navbar-brand">
        📚 ABSENSI SISWA
    </span>

    <button class="navbar-toggler"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

</div>

</nav>

<div class="container-fluid">
    <div class="row">

    <!-- Sidebar Desktop -->
    <div class="col-md-2 d-none d-md-block sidebar">

        <div class="p-3 text-center">

            <h4 class="logo-title text-white text-center">
    📚 ABSENSI SISWA
</h4>

            <small class="text-light">
                SDN Pondok Jagung 05
            </small>

        </div>

        <hr class="text-white">

        <ul class="nav flex-column">

            <li>
                <a href="/dashboard"
                   class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>
            </li>

            @if(Auth::check() && Auth::user()->role == 'admin')
            <li>
                <a href="/kelas"
                   class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                    🏫 Data Kelas
                </a>
            </li>
            @endif

            <li>
                <a href="/siswa"
                   class="nav-link {{ request()->is('siswa*') ? 'active' : '' }}">
                    👨‍🎓 Data Siswa
                </a>
            </li>

            <li>
                <a href="/scan"
                   class="nav-link {{ request()->is('scan*') ? 'active' : '' }}">
                    📷 Scan Barcode
                </a>
            </li>

            <li>
                <a href="/laporan"
                   class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                    📊 Laporan
                </a>
            </li>

        </ul>

        <hr class="text-white">

        <div class="text-white">

    <strong>{{ Auth::user()->name ?? '-' }}</strong>

    <br><br>

    <span class="role-badge">
        {{ strtoupper(Auth::user()->role ?? '-') }}
    </span>

</div>

       <form method="POST"
      action="{{ route('logout') }}">

    @csrf

    <button type="submit" class="btn btn-danger w-100">
        Logout
    </button>

</form>
    </div>

    <!-- Content -->
    <div class="col-12 col-md-10 content">

        @yield('content')

        <hr>

        <div class="text-center text-muted mt-3">
            © {{ date('Y') }} Sistem Absensi Barcode SDN Pondok Jagung 05
        </div>

    </div>

</div>

</div>

<!-- Sidebar HP -->

<div class="offcanvas offcanvas-start text-bg-primary"
     tabindex="-1"
     id="sidebarMenu">

<div class="offcanvas-header">

    <h5 class="offcanvas-title">
        📚 ABSENSI SISWA
    </h5>

    <button type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="offcanvas">
    </button>

</div>

<div class="offcanvas-body">

    <a href="/dashboard" class="nav-link text-white">
        🏠 Dashboard
    </a>

@if(Auth::check() && Auth::user()->role == 'admin')
    <a href="/kelas" class="nav-link text-white">
        🏫 Data Kelas
    </a>
    @endif

    <a href="/siswa" class="nav-link text-white">
        👨‍🎓 Data Siswa
    </a>

    <a href="/scan" class="nav-link text-white">
        📷 Scan Barcode
    </a>

    <a href="/laporan" class="nav-link text-white">
        📊 Laporan
    </a>

    <hr>

<strong>{{ Auth::user()->name ?? '-' }}</strong>

<br><br>

    <form method="POST"
          action="{{ route('logout') }}">

        @csrf

        <button class="btn btn-danger w-100">
            Logout
        </button>

    </form>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
