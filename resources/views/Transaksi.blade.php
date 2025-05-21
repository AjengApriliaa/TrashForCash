<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #244b36;
            --secondary-color: #d9eebb;
            --accent-color: #4caf50;
            --background-color: #ecf8cd;
            --light-text: #ffffff;
            --dark-text: #333333;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 0.8rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .left-links,
        .header .right-links {
            font-size: 0.85rem;
        }

        .header a:hover {
            opacity: 0.8;
        }

        .logo-section {
            background-color: var(--primary-color);
            padding: 1rem 1.5rem;
        }

        .logo-section img {
            height: 40px;
        }

        .search-bar {
            width: 100%;
            max-width: 300px;
        }

        .search-bar input {
            border: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--light-text);
            padding-left: 1rem;
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar {
            background-color: var(--secondary-color);
            min-height: 100vh;
            padding: 2rem 1.5rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        }

        .profile-box {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 1rem;
            padding: 1.5rem 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .profile-box img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-bottom: 0.75rem;
        }

        .sidebar .nav-link {
            color: var(--dark-text);
            font-weight: 500;
            margin-bottom: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: var(--light-text);
            font-weight: bold;
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
        }

        .content {
            padding: 2rem;
        }

        .content-header {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 1.25rem;
            border-radius: 0.75rem;
            font-weight: bold;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-header i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .content-box {
            background-color: var(--primary-color);
            padding: 2rem;
            border-radius: 0.75rem;
            color: var(--light-text);
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .transaction-card {
            background-color: #fff;
            border-radius: 0.75rem;
            padding: 1.75rem;
            margin-bottom: 1.75rem;
            color: var(--dark-text);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }

        .transaction-card:hover {
            transform: translateY(-3px);
        }

        .transaction-status {
            font-size: 0.85rem;
            padding: 0.35rem 0.85rem;
            border-radius: 2rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .transaction-details {
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid #eee;
        }

        .transaction-map {
            height: 180px;
            border-radius: 0.75rem;
            margin-top: 1rem;
            border: 2px solid #eee;
            overflow: hidden;
        }

        .transaction-image {
            width: 100%;
            border-radius: 0.75rem;
            max-height: 200px;
            object-fit: cover;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
        }

        .coin-badge {
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
        }

        .coin-badge i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .transaction-type {
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .transaction-type i {
            margin-right: 0.4rem;
        }

        .btn-cancel {
            background-color: #f8d7da;
            color: #721c24;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background-color: #e9c0c3;
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            margin: 0 0.5rem;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #1a3a28;
            color: white;
        }

        .btn-outline-primary-custom {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .transaction-detail-item {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: baseline;
        }

        .transaction-detail-item i {
            color: var(--accent-color);
            margin-right: 0.75rem;
            font-size: 0.9rem;
        }

        .transaction-detail-label {
            font-weight: 600;
            margin-right: 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                padding: 1.5rem 1rem;
            }

            .content {
                padding: 1.5rem 1rem;
            }

            .transaction-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header Top Links -->
    <div class="header d-flex justify-content-between align-items-center">
        <div class="left-links">
            <a href="{{ route('Kontakkami   ') }}" class="text-white text-decoration-none me-3">
                <i class="bi bi-telephone-fill me-1"></i> Call Center
            </a>
            <a href="{{ route('Kontakkami') }}" class="text-white text-decoration-none">
                <i class="bi bi-chat-dots-fill me-1"></i> Kontak Kami
            </a>
        </div>
        <div class="right-links">
            <a href="{{ route('Notifikasi') }}" class="text-white text-decoration-none me-3">
                <i class="bi bi-bell-fill me-1"></i> Notifikasi
            </a>
            <a href="{{ route('Bantuan') }}" class="text-white text-decoration-none me-3">
                <i class="bi bi-question-circle-fill me-1"></i> Bantuan
            </a>
            <a href="#" class="text-white text-decoration-none">
                <i class="bi bi-globe me-1"></i> Bahasa Indonesia
            </a>
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
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4caf50&color=fff"
                        alt="Profile Photo">
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <a href="{{ route('user.profile') }}" class="text-decoration-none text-success small">
                        <i class="bi bi-pencil-square me-1"></i>Ubah profil
                    </a>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ url('/Dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ url('/Buangsampah') }}">
                        <i class="bi bi-trash"></i> Buang Sampah
                    </a>
                    <a class="nav-link active" href="{{ url('/Transaksi') }}">
                        <i class="bi bi-arrow-left-right"></i> Transaksi
                    </a>
                    <a class="nav-link" href="{{ url('/Riwayattransaksi') }}">
                        <i class="bi bi-clock-history"></i> Riwayat Transaksi
                    </a>
                    <a class="nav-link" href="{{ url('/Koin') }}">
                        <i class="bi bi-coin"></i> Koinku
                    </a>
                    <a class="nav-link" href="{{ url('/Riwayatpenukaran') }}">
                        <i class="bi bi-receipt"></i> Riwayat Penukaran
                    </a>
                </nav>
            </div>


            @section('title', 'Transaksi Saya')

            @section('content')
                <div class="container py-4">
                    <h2 class="mb-4 text-center">Daftar Transaksi Sampah</h2>

                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($transaksis->isEmpty())
                        <div class="alert alert-info text-center">
                            Belum ada transaksi yang tercatat.
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach($transaksis as $transaksi)
                                <div class="col">
                                    <div class="card shadow-sm border-0 rounded-4">
                                        @php
                                            $imagePath = $transaksi->foto_path
                                                ? asset('storage/' . $transaksi->foto_path)
                                                : asset('images/default.png');
                                        @endphp

                                        <img src="{{ $imagePath }}" alt="Bukti Sampah" class="card-img-top rounded-top-4"
                                            style="height: 230px; object-fit: cover;">

                                        <div class="card-body">
                                            <h5 class="card-title">Layanan: <span
                                                    class="text-capitalize">{{ $transaksi->layanan }}</span></h5>
                                            <p class="card-text"><strong>Lokasi:</strong> {{ $transaksi->lokasi }}</p>
                                            <p class="card-text"><strong>Berat:</strong> {{ $transaksi->berat }} gram</p>
                                            <p class="card-text"><strong>Koin:</strong> {{ $transaksi->koin }} koin</p>
                                            <p class="card-text"><strong>Status:</strong>
                                                <span class="badge bg-warning text-dark">{{ ucfirst($transaksi->status) }}</span>
                                            </p>
                                            <div id="map-{{ $transaksi->id }}" class="mt-3 rounded-4" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endsection

            @section('scripts')
            <!-- Leaflet Maps -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    @foreach($transaksis as $transaksi)
                        const map{{ $transaksi->id }} = L.map("map-{{ $transaksi->id }}").setView(
                            [{{ $transaksi->latitude }}, {{ $transaksi->longitude }}],
                            15
                        );

                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
                            maxZoom: 18,
                        }).addTo(map{{ $transaksi->id }});

                        L.marker([{{ $transaksi->latitude }}, {{ $transaksi->longitude }}])
                            .addTo(map{{ $transaksi->id }})
                            .bindPopup("{{ $transaksi->lokasi }}")
                            .openPopup();
                    @endforeach
        });
            </script>

        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>