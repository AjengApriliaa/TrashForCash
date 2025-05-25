<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Bantuan - TrashForCash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #d9eebb;
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            background-color: #244b36;
            color: white;
            padding: 0.8rem 1.5rem;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin-right: 1rem;
            font-size: 0.85rem;
        }

        .logo-section {
            background-color: #244b36;
            padding: 1rem 1.5rem;
            position: relative;
        }

        .logo-section img {
            height: 40px;
        }

        .search-bar {
            max-width: 300px;
            width: 100%;
        }

        .btn-back-icon {
            position: absolute;
            bottom: -70px;
            left: 15px;
            font-size: 1.8rem;
            color: #244b36;
            background: none;
            border: none;
            z-index: 10;
        }

        .btn-back-icon:hover {
            color: #000;
        }

        .help-title {
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .help-card {
            background-color: #f3ffe2;
            border: none;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .help-card:hover {
            transform: translateY(-5px);
        }

        .help-card .card-body {
            text-align: center;
        }

        .help-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .help-container {
            max-width: 800px;
            margin: auto;
            padding: 3rem 1rem 1rem 1rem;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <div>
            <a href="Kontakkami">call center</a>
            <a href="Kontakkami">kontak kami</a>
        </div>
        <div>
            <a href="Notifikasi">Notifikasi</a>
            <a href="Bantuan">Bantuan</a>
            <a href="#">Bahasa Indonesia</a>
        </div>
    </div>

    <!-- Logo + Search -->
    <div class="logo-section d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="TrashForCash Logo" class="me-2">
            <span class="text-white fw-bold fs-5">Trash<br>ForCash</span>
        </div>
        <form class="d-flex search-bar" role="search">
            <input class="form-control rounded-pill" type="search" placeholder="Cari" aria-label="Cari">
        </form>

        <!-- Tombol Kembali -->
        <a href="/dashboard" class="btn-back-icon" title="Kembali ke Dashboard">
            <i class="bi bi-arrow-left-circle-fill"></i>
        </a>
    </div>

    <!-- Konten Bantuan -->
    <div class="help-container text-center">
        <div class="help-title">Ada yang Bisa Kami Bantu?</div>

        <div class="mb-4 mx-auto" style="max-width: 700px;">
            <div class="search-box bg-white rounded-3 shadow-sm p-3 d-flex align-items-center">
                <i class="bi bi-search me-2"></i>
                <input type="text" class="form-control border-0" placeholder="Dapatkan Bantuanmu">
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card help-card">
                    <div class="card-body">
                        <i class="bi bi-trash-fill"></i>
                        <h5 class="card-title">Jenis Sampah</h5>
                        <p class="card-text">Jenis sampah apa saja yang bisa ditukarkan ke koin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card help-card">
                    <div class="card-body">
                        <i class="bi bi-truck"></i>
                        <h5 class="card-title">Antar Jemput</h5>
                        <p class="card-text">Permasalahan dalam Antar Jemput Sampah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card help-card">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar"></i>
                        <h5 class="card-title">Penukaran Koin</h5>
                        <p class="card-text">Masalah dalam transaksi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @include('Footer')
</body>

</html>