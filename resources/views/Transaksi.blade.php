<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi - TrashForCash</title>
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
            <div class="col-md-3 sidebar">
                <div class="profile-box text-center">
                    <h5>{{ Auth::user()->name }}</h5>
                    <a href="{{ route('user.profile') }}" class="text-decoration-none text-success small">Ubah
                        profil</a>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="Dashboard">Dashboard</a>
                    <a class="nav-link active" href="Buangsampah">Buang Sampah</a>
                    <a class="nav-link" href="Transaksi">Transaksi</a>
                    <a class="nav-link" href="Riwayattransaksi">Riwayat Transaksi</a>
                    <a class="nav-link" href="Koin">Koinku</a>
                    <a class="nav-link" href="Riwayatpenukaran">Riwayat Penukaran Koinku</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 content">
                <div class="content-header">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Transaksi Sampah</span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(isset($transaksis) && $transaksis->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-basket"></i>
                        <h4>Belum Ada Transaksi</h4>
                        <p>Anda belum memiliki transaksi sampah yang sedang berlangsung.</p>
                        <a href="{{ url('/Buangsampah') }}" class="btn btn-primary-custom">
                            <i class="bi bi-plus-lg me-2"></i>Buang Sampah Sekarang
                        </a>
                    </div>
                @else
                    <div class="row">
                        @foreach($transaksis as $transaksi)
                            <div class="col-md-6 mb-4">
                                <div class="transaction-card">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1">
                                                @if($transaksi->layanan == 'antar')
                                                    <i class="bi bi-box-arrow-in-right text-success me-2"></i>Antar Sampah
                                                @else
                                                    <i class="bi bi-truck text-primary me-2"></i>Jemput Sampah
                                                @endif
                                            </h5>
                                            <div class="transaction-type">
                                                <i class="bi bi-calendar3"></i>
                                                {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                        <span class="transaction-status status-{{ $transaksi->status }}">
                                            @if($transaksi->status == 'pending')
                                                <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                            @elseif($transaksi->status == 'processing')
                                                <i class="bi bi-arrow-repeat me-1"></i>Diproses
                                            @elseif($transaksi->status == 'completed')
                                                <i class="bi bi-check-circle me-1"></i>Selesai
                                            @elseif($transaksi->status == 'cancelled')
                                                <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                            @endif
                                        </span>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            @php
                                                $imagePath = $transaksi->foto_path
                                                    ? asset('storage/' . $transaksi->foto_path)
                                                    : asset('images/default.png');
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="Foto Sampah" class="transaction-image">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="transaction-detail-item">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <div>
                                                    <span class="transaction-detail-label">Lokasi:</span>
                                                    <span>{{ $transaksi->lokasi }}</span>
                                                </div>
                                            </div>
                                            <div class="transaction-detail-item">
                                                <i class="bi bi-speedometer"></i>
                                                <div>
                                                    <span class="transaction-detail-label">Berat:</span>
                                                    <span>{{ $transaksi->berat }} gram</span>
                                                </div>
                                            </div>
                                            <div class="transaction-detail-item">
                                                <i class="bi bi-coin"></i>
                                                <div>
                                                    <span class="transaction-detail-label">Koin:</span>
                                                    <span class="coin-badge">
                                                        <i class="bi bi-coin"></i>{{ $transaksi->koin }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="transaction-map" id="map-{{ $transaksi->id }}"></div>

                                    @if($transaksi->status == 'pending')
                                        <div class="mt-3 text-end">
                                            <form action="{{ route('transaksi.cancel', $transaksi->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-cancel"
                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                                                    <i class="bi bi-x-circle me-1"></i>Batalkan
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet Maps Init -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @foreach($transaksis as $transaksi)
                var map{{ $transaksi->id }} = L.map("map-{{ $transaksi->id }}").setView(
                    [{{ $transaksi->latitude }}, {{ $transaksi->longitude }}],
                    15
                );

                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18
                }).addTo(map{{ $transaksi->id }});

                L.marker([{{ $transaksi->latitude }}, {{ $transaksi->longitude }}])
                    .addTo(map{{ $transaksi->id }})
                    .bindPopup("{{ $transaksi->lokasi }}")
                    .openPopup();
            @endforeach
        });
    </script>
</body>
</html>