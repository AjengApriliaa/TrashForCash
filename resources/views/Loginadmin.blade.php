<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #efffcf;
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5% 10%;
            height: 100vh;
        }

        .left-text {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000;
        }

        .trash-image img {
            width: 100%;
            max-width: 350px;
        }

        .login-box {
            max-width: 400px;
            width: 100%;
        }

        .form-control {
            border: 1px solid #444;
        }

        .btn-login {
            background-color: #3c73ff;
            color: #fff;
            width: 100%;
        }

        .form-label {
            text-transform: lowercase;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="left">
            <div class="left-text">Dari Sampah<br>Ke Rupiah</div>
            <div class="trash-image mt-4">
                <img src="{{ asset('asset/bank-sampah.png') }}" alt="Trash Bins">
            </div>
        </div>
        <div class="login-box">
            <div class="text-center mb-3">
                <img src="{{ asset('asset/tfclogodark2.svg') }}" alt="Logo" style="width: 120px;">
                <h4 class="mt-2">LOG IN ADMIN</h4>
                <small>Masuk sebagai Admin</small>
            </div>

            {{-- Tampilkan pesan error jika login gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email" name="email" required placeholder="Email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">kata sandi</label>
                    <input class="form-control" type="password" name="password" required placeholder="Password">
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span></span>
                    <a href="#" style="font-size: small;">Lupa Kata sandi?</a>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
    </div>
</body>

</html>