
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg,#4f46e5,#2563eb);
            font-family:'Segoe UI',sans-serif;
        }

        .login-card{
            width:100%;
            max-width:430px;
            background:white;
            padding:40px;
            border-radius:20px;
            box-shadow:0 20px 40px rgba(0,0,0,.15);
        }

        .logo{
            text-align:center;
            margin-bottom:15px;
        }

        .logo img{
            width:180px;
            height:180px;
            object-fit:contain;
        }

        h2{
            text-align:center;
            font-weight:bold;
            color:#1e3a8a;
            margin-bottom:10px;
        }

        .subtitle{
            text-align:center;
            color:#6b7280;
            margin-bottom:30px;
        }

        .form-control{
            border-radius:12px;
            height:50px;
        }

        .btn-login{
            width:100%;
            height:50px;
            border:none;
            border-radius:12px;
            background:#2563eb;
            color:white;
            font-weight:bold;
            transition:.3s;
        }

        .btn-login:hover{
            background:#1d4ed8;
        }

        .footer{
            text-align:center;
            margin-top:20px;
            color:#6b7280;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="logo">
        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo Sekolah">
    </div>

    <h2>Login Sistem</h2>

    <p class="subtitle">
        Sistem Absensi Barcode SDN Pondok Jagung 05
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Masukkan Email"
                required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan Password"
                required>
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>
    </form>

    <div class="footer">
        © {{ date('Y') }} SDN Pondok Jagung 05
    </div>

</div>

</body>
</html>

