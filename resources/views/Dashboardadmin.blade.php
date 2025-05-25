<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Leaflet, Axios -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #ecf8cd;
            font-family: 'Segoe UI', sans-serif;
        }

        .header,
        .logo-section {
            background-color: #244b36;
            color: white;
        }

        .header {
            padding: 0.8rem 1.5rem;
            font-size: 0.85rem;
        }

        .logo-section {
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

        .main-content {
            padding: 2rem;
        }

        .main-content h2 {
            background-color: #244b36;
            color: white;
            padding: 0.8rem;
            border-radius: 0.5rem;
            font-weight: bold;
        }

        .card-container {
            display: flex;
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .card {
            background-color: white;
            flex: 1;
            padding: 1.5rem;
            border-radius: 0.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 2rem;
            margin-top: 0.5rem;
        }

        .about {
            background-color: #244b36;
            color: white;
            padding: 2rem;
            border-radius: 0.5rem;
        }

        footer {
            background-color: #244b36;
            color: white;
            padding: 2rem;
            margin-top: 2rem;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-logo {
            width: 60px;
        }
    </style>
</head>

<body>

    <!-- Logo & Search -->
    <div class="logo-section d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="Logo TrashForCash" class="me-2">
            <span class="fw-bold fs-5">Trash<br>ForCash</span>
        </div>
        <form class="d-flex search-bar" role="search">
            <input class="form-control rounded-pill" type="search" placeholder="Cari" aria-label="Cari">
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="profile">
                    <img src="{{ asset('asset/admin-profile.png') }}" alt="Foto Admin">
                    <h5>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</h5>
                    <a href="{{ route('user.profile') }}" class="text-decoration-none text-success small">Ubah
                        profil</a>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('admin.transaksi.index') }}">Faktur Transaksi</a>
                    <a class="nav-link active" href="{{ route('admin.transaksi.riwayat') }}">Riwayat Transaksi</a>
                    <a class="nav-link" href="{{ route('admin.kelolauser') }}">Kelola User</a>

                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <h2 class="text-center mt4 ">Dashboard</h2>

                <div class="about">
                    <div class="card-container">
                        <div class="card">
                            <p>Jumlah Pengguna Keseluruhan</p>
                            <h3>{{ $jumlahPengguna }}</h3>
                        </div>
                        <div class="card">
                            <p>Pengguna Aktif</p>
                            <h3>{{ $jumlahPenggunaAktif }}</h3>
                        </div>
                        <div class="card">
                            <p>Riwayat Transaksi</p>
                            <h3>{{ $jumlahTransaksi }}</h3>
                        </div>
                    </div>



                    <div class="about">
                        <h3 class="text-center">Tentang Aplikasi</h3>
                        <p>
                            Trash Forcash adalah platform yang bertujuan untuk membantu Anda mengelola sampah dengan
                            cara
                            yang lebih berkelanjutan dan menguntungkan. Dengan Trash Forcash, Anda dapat dengan mudah
                            mendaur ulang sampah Anda tanpa ribet. Kami menyediakan fasilitas untuk memasukkan jenis dan
                            berat sampah Anda, dan dalam sekejap, Anda akan mendapatkan insentif berupa koin yang dapat
                            ditukar dengan hadiah atau uang tunai.

                            Kami percaya bahwa berkontribusi pada lingkungan yang lebih baik haruslah menjadi pengalaman
                            yang mudah dan bermanfaat bagi semua orang. Dengan Trash Forcash, Anda tidak hanya membantu
                            mengurangi limbah yang mencemari lingkungan, tetapi juga memiliki kesempatan untuk
                            mendapatkan
                            manfaat dari upaya Anda.

                            Bergabunglah dengan komunitas Trash Forcash sekarang dan mari bersama-sama menjadikan dunia
                            lebih bersih, lebih hijau, dan lebih berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>

            @include('Footer')
</body>

</html>