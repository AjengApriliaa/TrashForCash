<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayatpenukaran - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
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
                    <a class="nav-link" href="dashboard">Dashboard</a>
                    <a class="nav-link" href="Buangsampah">Buang Sampah</a>
                    <a class="nav-link" href="Transaksi">Transaksi</a>
                    <a class="nav-link" href="Riwayattransaksi">Riwayat Transaksi</a>
                    <a class="nav-link" href="Koin">Koinku</a>
                    <a class="nav-link active" href="Riwayatpenukaran">Riwayat Penukaran Koinku</a>
                    <a class="nav-link" href="Login">Logout</a>
                </nav>
            </div>

            <!-- Main Content Riwayat Penukaran Koin -->
            <div class="col-md-9 py-4">
                <!-- Judul -->
                <div class="card border-0 mb-4" style="background-color: #1f3d2b; color: white; border-radius: 15px;">
                    <div class="card-body text-center">
                        <h5 class="mb-0 fw-bold">Riwayat Penukaran Koin</h5>
                    </div>
                </div>

                <!-- Tabel Riwayat Penukaran Koin -->
                <div class="card border-0" style="background-color: #1f3d2b; color: white; border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table text-white table-borderless mb-0">
                                <thead>
                                    <tr class="border-bottom">
                                        <th>No</th>
                                        <th>Koin Saya</th>
                                        <th>Koin yang Di Tukar</th>
                                        <th>Nominal Rupiah</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($penukaranKoin as $index => $data)
                                        <tr class="border-bottom">
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ Auth::user()->coin }} PC</td> <!-- Coin saat ini -->
                                            <td>-{{ $data->koin_ditukar }} PC</td>
                                            <td>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            @include('Footer')
</body>

</html>