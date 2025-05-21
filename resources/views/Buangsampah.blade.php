<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buangsampah/Antar - TrashForCash</title>
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
                <div class="content-header text-center">Buang Sampah</div>
                <div class="content-box">
                    <!-- Tabs Antar / Jemput -->
                    <ul class="nav nav-tabs mb-4 justify-content-center">
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('/Buangsampah') }}"
                                class="nav-link {{ request()->is('Buangsampah') ? 'active' : '' }}">
                                Antar
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('/Jemput') }}"
                                class="nav-link {{ request()->is('Jemput') ? 'active' : '' }}">
                                Jemput
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="buangSampahTabContent">
                        <div class="tab-pane fade show active" id="antar" role="tabpanel">
                            <!-- Form Buang Sampah -->
                            <form action="{{ route('transaksi.simpan') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="layanan" value="antar">

                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Detail Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        id="lokasi" name="lokasi" placeholder="Masukkan lokasi..."
                                        value="{{ old('lokasi') }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Hidden koordinat -->
                                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">

                                    <!-- Map -->
                                    <div id="map" class="rounded mt-2" style="height: 300px;"></div>
                                </div>

                                <!-- Estimasi Berat -->
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <input type="number" id="berat" name="berat"
                                            class="form-control me-2 @error('berat') is-invalid @enderror"
                                            value="{{ old('berat', 0) }}" min="0" required style="width: 100px;">
                                        <span>gr</span>
                                    </div>
                                    <span id="coin-estimate" class="badge bg-success rounded-pill px-3 py-2">0 coin
                                        <small class="d-block">Estimasi</small>
                                    </span>
                                    @error('berat')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Upload Foto -->
                                <div class="mb-4">
                                    <label class="form-label">Upload Bukti Pengantaran</label>
                                    <input type="file" class="form-control @error('bukti_foto') is-invalid @enderror"
                                        name="bukti_foto" accept="image/*" required>
                                    @error('bukti_foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tombol Kirim -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-dark px-4">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('footer')

</body>
<script>
    var map = L.map('map').setView([-5.3971, 105.2668], 13); // Default ke Bandar Lampung

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    // Saat input berubah, cari lokasi
    document.getElementById('lokasi').addEventListener('change', function () {
        var lokasi = this.value;
        if (lokasi.length > 3) {
            axios.get('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(lokasi))
                .then(function (response) {
                    if (response.data.length > 0) {
                        var lat = response.data[0].lat;
                        var lon = response.data[0].lon;

                        // Pindahkan peta
                        map.setView([lat, lon], 15);

                        // Tambahkan marker
                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker([lat, lon]).addTo(map)
                            .bindPopup(lokasi)
                            .openPopup();

                        // Simpan ke hidden input
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                    }
                })
                .catch(function (error) {
                    console.error('Gagal mencari lokasi:', error);
                });
        }
    });
</script>
<script>
    const beratInput = document.getElementById('berat');
    const coinDisplay = document.getElementById('coin-estimate');

    beratInput.addEventListener('input', function () {
        const berat = parseInt(beratInput.value) || 0;
        const koin = berat * 2;
        coinDisplay.innerHTML = `${koin} coin <small class="d-block">Estimasi</small>`;
    });
</script>

</html>