
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
            overflow-x:hidden;
        }

        .sidebar{
            width:250px;
            min-height:100vh;
            background:#1e3a8a;
            color:white;
            padding:20px;
        }

        .sidebar h3{
            font-size:22px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .menu{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px 15px;
            border-radius:10px;
            margin-bottom:8px;
            transition:.3s;
        }

        .menu:hover{
            background:rgba(255,255,255,.15);
            color:white;
        }

        .content{
            flex-grow:1;
            padding:25px;
        }

        .user-box{
            margin-top:20px;
            padding:15px;
            background:rgba(255,255,255,.1);
            border-radius:10px;
        }

        .role-badge{
            font-size:12px;
            background:#22c55e;
            padding:4px 10px;
            border-radius:20px;
        }
    </style>
</head>
<body>

<div class="d-flex">

    <div class="sidebar">

        <h3>📚 ABSENSI SISWA</h3>

        <hr>

        <a href="/dashboard" class="menu">
            🏠 Dashboard
        </a>

        @if(Auth::user()->role == 'admin')
        <a href="/kelas" class="menu">
            🏫 Data Kelas
        </a>
        @endif

        <a href="/siswa" class="menu">
            👨‍🎓 Data Siswa
        </a>

        <a href="/scan" class="menu">
            📷 Scan Barcode
        </a>

        <a href="/laporan" class="menu">
            📊 Laporan
        </a>

        <hr>

        @auth

        <div class="user-box">

            <strong>{{ Auth::user()->name }}</strong>
            <br><br>

            <span class="role-badge">
                {{ strtoupper(Auth::user()->role) }}
            </span>

        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf

            <button class="btn btn-danger w-100">
                Logout
            </button>
        </form>

        @endauth

    </div>

    <div class="content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>

