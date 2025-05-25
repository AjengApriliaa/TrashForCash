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

        .user-info-box {
            background-color: white;
            color: #000;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .search-bar {
            width: 100%;
            max-width: 300px;
        }

        .alert {
            margin-bottom: 1rem;
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

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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

                    <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="layanan" value="jemput">

                        <!-- Informasi User -->
                        <div class="user-info-box d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small>{{ Auth::user()->telepon ?? 'Telepon belum diatur' }}</small><br>
                                <small>{{ Auth::user()->alamat ?? 'Alamat belum diatur' }}</small>
                            </div>
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-pencil"></i> Ubah
                            </a>
                        </div>

                        <!-- Lokasi Penjemputan -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Detail Lokasi Penjemputan</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" placeholder="Masukkan detail lokasi penjemputan..."
                                value="{{ old('lokasi') }}" required>
                            <small class="form-text text-light">Contoh: Depan gerbang utama, lantai 2 gedung A,
                                dll.</small>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <div id="map" class="rounded mt-2" style="height: 300px;"></div>
                        </div>

                        <!-- Estimasi Berat -->
                        <div class="mb-3">
                            <label for="berat" class="form-label">Estimasi Berat Sampah</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <input type="number" name="berat" id="berat"
                                        class="form-control me-2 @error('berat') is-invalid @enderror" min="1" step="1"
                                        value="{{ old('berat', 1) }}" style="width: 120px;" required>
                                    <span>gram</span>
                                </div>
                                <span id="coin-estimate" class="badge bg-success rounded-pill px-3 py-2">+2 koin
                                    <small class="d-block">Estimasi</small>
                                </span>
                            </div>
                            <small class="form-text text-light">Perkirakan berat total sampah yang akan dijemput</small>
                            @error('berat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload Bukti -->
                        <div class="mb-4">
                            <label class="form-label">Upload Foto Sampah</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                accept="image/*" required>
                            <small class="form-text text-light">Format: JPG, JPEG, PNG. Maksimal 2MB. Foto digunakan
                                untuk verifikasi jenis dan kondisi sampah.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi Penjemputan</h6>
                            <small>
                                • Tim penjemput akan datang sesuai jadwal yang telah ditentukan<br>
                                • Pastikan sampah sudah dipilah dan dikemas dengan baik<br>
                                • Anda akan mendapat notifikasi saat tim dalam perjalanan<br>
                                • Estimasi koin akan diverifikasi setelah penimbangan
                            </small>
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-light px-4">
                                <i class="bi bi-truck"></i> Ajukan Penjemputan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Map Script -->
    <script>
        var map = L.map('map').setView([-5.3971, 105.2668], 13); // Default ke Bandar Lampung

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        // Set marker di alamat user jika tersedia
        @if(Auth::user()->alamat)
            // Geocoding alamat user untuk menampilkan marker awal
            axios.get('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent('{{ Auth::user()->alamat }}'))
                .then(function (response) {
                    if (response.data.length > 0) {
                        var lat = response.data[0].lat;
                        var lon = response.data[0].lon;

                        map.setView([lat, lon], 15);
                        marker = L.marker([lat, lon]).addTo(map)
                            .bindPopup('{{ Auth::user()->alamat }}')
                            .openPopup();

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                    }
                })
                .catch(function (error) {
                    console.log('Alamat tidak dapat ditemukan di peta');
                });
        @endif

        // Saat input lokasi berubah, cari lokasi
        document.getElementById('lokasi').addEventListener('input', function () {
            var lokasi = this.value;
            if (lokasi.length > 3) {
                // Debounce untuk menghindari terlalu banyak request
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(function () {
                    searchLocation(lokasi);
                }, 500);
            }
        });

        function searchLocation(lokasi) {
            // Gabungkan dengan alamat user untuk pencarian yang lebih akurat
            var fullAddress = lokasi;
            @if(Auth::user()->alamat)
                fullAddress = lokasi + ', {{ Auth::user()->alamat }}';
            @endif

            axios.get('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(fullAddress))
                .then(function (response) {
                    if (response.data.length > 0) {
                        var lat = response.data[0].lat;
                        var lon = response.data[0].lon;

                        // Pindahkan peta
                        map.setView([lat, lon], 16);

                        // Tambahkan marker
                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker([lat, lon]).addTo(map)
                            .bindPopup(response.data[0].display_name)
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

        // Klik pada peta untuk memilih lokasi
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Tambahkan marker
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);

            // Simpan koordinat
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Reverse geocoding untuk mendapatkan alamat
            axios.get(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(function (response) {
                    if (response.data && response.data.display_name) {
                        marker.bindPopup(response.data.display_name).openPopup();
                    }
                })
                .catch(function (error) {
                    console.error('Gagal mendapatkan alamat:', error);
                });
        });
    </script>

    <!-- Coin Calculation Script -->
    <script>
        const beratInput = document.getElementById('berat');
        const coinDisplay = document.getElementById('coin-estimate');

        function updateCoinEstimate() {
            const berat = parseInt(beratInput.value) || 0;
            const koin = berat * 2; // 1 gram = 2 koin
            coinDisplay.innerHTML = `+${koin} koin <small class="d-block">Estimasi</small>`;
        }

        beratInput.addEventListener('input', updateCoinEstimate);

        // Set initial value
        updateCoinEstimate();

        // Auto hide alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>

</body>

</html>