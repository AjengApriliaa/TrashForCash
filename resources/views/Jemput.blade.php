<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jemput Sampah - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Leaflet CSS & JS -->
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
        }

        .logo-section {
            padding: 1rem 1.5rem;
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

    <!-- Header -->
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

    <!-- Logo -->
    <div class="logo-section d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="Logo TrashForCash" class="me-2" height="40">
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
                <div class="profile text-center mb-4">
                    <h5>{{ Auth::user()->name }}</h5>
                    <a href="{{ route('user.profile') }}" class="text-decoration-none text-success small">Ubah
                        profil</a>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ url('/Dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ url('/Buangsampah') }}">Buang Sampah</a>
                    <a class="nav-link active" href="{{ url('/Jemput') }}">Jemput Sampah</a>
                    <a class="nav-link" href="{{ url('/Transaksi') }}">Transaksi</a>
                    <a class="nav-link" href="{{ url('/Riwayattransaksi') }}">Riwayat Transaksi</a>
                    <a class="nav-link" href="{{ url('/Koin') }}">Koinku</a>
                    <a class="nav-link" href="{{ url('/Riwayatpenukaran') }}">Riwayat Penukaran Koinku</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 content">
                <div class="content-header text-center">Jemput Sampah</div>
                <div class="content-box">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4 justify-content-center">
                        <li class="nav-item">
                            <a href="{{ url('/Buangsampah') }}"
                                class="nav-link {{ request()->is('Buangsampah') ? 'active' : '' }}">Antar</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/Jemput') }}"
                                class="nav-link {{ request()->is('Jemput') ? 'active' : '' }}">Jemput</a>
                        </li>
                    </ul>

                    <!-- Tambahkan sebelum <form> jika ingin menampilkan pesan error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi kesalahan:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transaksi.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="layanan" value="jemput">

                        <!-- Informasi User -->
                        <div class="mb-4 d-flex justify-content-between bg-white text-dark p-3 rounded">
                            <div>
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small>{{ Auth::user()->telepon }}</small><br>
                                <small>{{ Auth::user()->alamat }}</small>
                            </div>
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-dark btn-sm">Ubah</a>
                        </div>

                        <!-- Lokasi Penjemputan -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Detail Lokasi</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" placeholder="Masukkan lokasi..." value="{{ old('lokasi') }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <div id="map" class="rounded mt-2" style="height: 300px;"></div>
                        </div>

                        <!-- Estimasi Berat -->
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <input type="number" name="berat" id="berat"
                                    class="form-control me-2 @error('berat') is-invalid @enderror" min="1" step="1"
                                    value="{{ old('berat', 0) }}" style="width: 80px;" required>
                                <span>gr</span>
                                @error('berat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <span id="coin-estimate" class="badge bg-success rounded-pill px-3 py-2">+0 coin
                                <small class="d-block">Estimasi</small>
                            </span>
                        </div>

                        <!-- Upload Bukti -->
                        <div class="mb-4">
                            <label class="form-label">Upload Foto Sampah</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                required>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-light px-4">Kirim</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Map & Estimasi Coin -->
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

    @include('footer')
</body>

</html>