<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Profil - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-card {
            margin-bottom: 4rem;
            /* Tambah jarak bawah */
        }

        footer {
            margin-top: 2rem;
            padding: 2rem;
            background-color: #d9eebb;
            text-align: center;
        }

        body {
            background-color: #ecf8cd;
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            background-color: #244b36;
            color: white;
            padding: 0.8rem 1.5rem;
        }

        .header .left-links,
        .header .right-links {
            font-size: 0.85rem;
        }

        .logo-section {
            background-color: #244b36;
            padding: 1rem 1.5rem;
        }

        .logo-section img {
            height: 40px;
        }

        .search-bar {
            width: 100%;
            max-width: 300px;
        }

        .sidebar {
            background-color: #d9eebb;
            min-height: 100vh;
            padding: 2rem 1.5rem;
        }

        .sidebar .nav-link {
            color: #000;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .sidebar .nav-link.active {
            font-weight: bold;
        }

        .profile {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .content {
            padding: 2rem;
        }

        .content-header {
            background-color: #244b36;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .content-box {
            background-color: #244b36;
            padding: 1.5rem;
            border-radius: 0.5rem;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Header Top Links -->
    <div class="header d-flex justify-content-between align-items-center">
        <div class="left-links">
            <a href="Kontakkami" class="text-white text-decoration-none me-3">call center</a>
            <a href="Kontakkami" class="text-white text-decoration-none">kontak kami</a>
        </div>
        <div class="right-links">
            <a href="Notifikasi" class="text-white text-decoration-none me-3">Notifikasi</a>
            <a href="Bantuan" class="text-white text-decoration-none me-3">Bantuan</a>
            <a href="#" class="text-white text-decoration-none">Bahasa Indonesia</a>
        </div>
    </div>

    <!-- Logo + Search -->
    <div class="logo-section d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="Logo TrashForCash" class="me-2">
            <span class="text-white fw-bold fs-5">Trash<br>ForCash</span>
        </div>
        <form class="d-flex search-bar" role="search">
            <input class="form-control rounded-pill" type="search" placeholder="Cari" aria-label="Cari">
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="profile-box text-center">
                    <h5>{{ Auth::user()->name }}</h5>
                    <a href="{{ route('user.profile') }}" class="text-decoration-none text-success small">Ubah
                        profil</a>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="dashboard">Dashboard</a>
                    <a class="nav-link" href="Buangsampah">Buang Sampah</a>
                    <a class="nav-link" href="Transaksi">Transaksi</a>
                    <a class="nav-link" href="Riwayattransaksi">Riwayat Transaksi</a>
                    <a class="nav-link" href="Koin">Koinku</a>
                    <a class="nav-link" href="Riwayatpenukaran">Riwayat Penukaran Koinku</a>
                </nav>
            </div>

            <!-- Form -->
            <div class="col-md-9">
                <div class="form-card mt-5 mx-4">
                    <div class="form-header bg-success p-3 rounded text-white mb-4">
                        <h5 class="mb-1">Profil</h5>
                        <p class="small mb-0">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan
                            akun</p>
                    </div>
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Nama Panjang</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control"
                                value="{{ old('alamat', $user->alamat) }}">
                        </div>

                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                value="{{ old('telepon', $user->telepon) }}">
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin</label><br>
                            <input type="radio" name="jenis_kelamin" value="Laki-Laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}> Laki-Laki
                            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}> Perempuan
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</body>

</html>