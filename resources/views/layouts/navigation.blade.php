<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Absensi Siswa
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/kelas">Data Kelas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/siswa">Data Siswa</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/scan">Scan Barcode</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/laporan">Laporan</a>
                </li>
            </ul>

            @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link">
                        {{ Auth::user()->name }}
                    </span>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mt-1">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
            @endauth

        </div>
    </div>
</nav>