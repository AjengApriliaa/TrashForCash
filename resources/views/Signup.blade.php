<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #ecf8cd;
            font-family: 'Segoe UI', sans-serif;
        }

        .left-text h1 {
            font-weight: 700;
            font-size: 2.8rem;
        }

        .register-form input {
            background-color: #f6f6f6;
            border-radius: 0.5rem;
        }

        .logo-top {
            height: 250px;
            margin-top: 70%;
        }

        .auth-options button {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .row {
            width: 100%;
        }

        .col-md-6 {
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row align-items-center justify-content-center">
            <!-- Kiri -->
            <div class="col-md-6 mb-5 mb-md-0">
                <div class="left-text text-md-start text-center px-3 px-md-5">
                    <h1 class="mb-4">Dari Sampah<br>Ke Rupiah</h1>
                    <img src="{{ asset('asset/bank-sampah.png') }}" class="img-fluid" alt="Sampah">
                </div>
            </div>

            <!-- Kanan -->
            <div class="col-md-6 px-3 px-md-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('asset/tfclogodark2.svg') }}" class="logo-top mb-3" alt="Logo Atas">
                </div>

                <div class="text-center mb-4">
                    <h4 class="fw-bold">Daftar Yuk</h4>
                    <small><strong>Baru!</strong> Nikmati kemudahan sistem autentikasi
                        tunggal untuk mengakses semua layanan dengan satu akun.</small>
                </div>

                <div class="auth-options d-flex justify-content-center mb-3 gap-3">
                    <button class="btn btn-outline-secondary" title="Google"><i class="bi bi-google"></i></button>
                    <button class="btn btn-outline-secondary" title="Telepon"><i class="bi bi-telephone"></i></button>
                </div>

                <div class="text-center text-muted mb-3">
                    <hr class="w-25 d-inline-block"> <small>Atau lanjutkan dengan</small>
                    <hr class="w-25 d-inline-block">
                </div>

                <!-- Error messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ old('name') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Kata Sandi" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">Daftar</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <small>Sudah punya akun? <a href="{{ url('Login') }}">Masuk</a></small>
                </div>
            </div>
        </div>
    </div>

</body>

</html>