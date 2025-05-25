<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Leaflet JS -->
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

        .transaction-card {
            background-color: #244b36;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            border: none;
        }

        .transaction-detail-item {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: baseline;
        }

        .transaction-detail-label {
            font-weight: 600;
            margin-right: 0.5rem;
            min-width: 130px;
        }

        .transaction-detail-value {
            flex: 1;
        }

        .status-badge {
            background-color: #f8f9fa;
            color: #000;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cff4fc;
            color: #055160;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #fff;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .btn-chat {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .btn-chat:hover {
            background-color: #5a6268;
            color: white;
        }

        footer {
            background-color: #244b36;
            color: white;
            padding: 1rem 0;
            text-align: center;
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

            .transaction-detail-label {
                min-width: 110px;
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

    <!-- MAIN CONTENT -->
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
                    <a class="nav-link" href="Buangsampah">Buang Sampah</a>
                    <a class="nav-link active" href="Transaksi">Transaksi</a>
                    <a class="nav-link" href="Riwayattransaksi">Riwayat Transaksi</a>
                    <a class="nav-link" href="Koin">Koinku</a>
                    <a class="nav-link" href="Riwayatpenukaran">Riwayat Penukaran Koinku</a>
                    <a class="nav-link" href="Login">Logout</a>
                </nav>
            </div>
            <div class="col-md-9 content">
                <div class="content-header text-center">Transaksi</div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Transaksi List -->
                @forelse($transaksis as $transaksi)
                    <div class="transaction-card">
                        <!-- Header Transaksi -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Transaksi</h5>

                        </div>

                        <!-- Detail Transaksi -->
                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Tipe Transaksi</span>
                            <span class="transaction-detail-value">: {{ ucfirst($transaksi->layanan) }}</span>
                        </div>

                        @if($transaksi->layanan === 'antar' && $transaksi->lokasi_antar)
                            <div class="transaction-detail-item">
                                <span class="transaction-detail-label">Lokasi Antar</span>
                                <span class="transaction-detail-value">: {{ $transaksi->lokasi_antar }}</span>
                            </div>
                        @endif

                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Nama</span>
                            <span class="transaction-detail-value">: {{ $transaksi->user->name }}</span>
                        </div>

                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Alamat</span>
                            <span class="transaction-detail-value">: {{ $transaksi->alamat }}</span>
                        </div>

                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Estimasi Berat</span>
                            <span class="transaction-detail-value">: {{ number_format($transaksi->berat, 0) }} Gram</span>
                        </div>

                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Estimasi Koin</span>
                            <span class="transaction-detail-value">: {{ number_format($transaksi->estimasi_koin, 0) }}
                                koin</span>
                        </div>

                        <div class="transaction-detail-item">
                            <span class="transaction-detail-label">Status</span>
                            <span class="transaction-detail-value">:
                                <span class="status-badge status-{{ $transaksi->status }}">
                                    {{ $transaksi->status_indonesia }}
                                </span>
                            </span>
                        </div>

                        @if($transaksi->tanggal)
                            <div class="transaction-detail-item">
                                <span class="transaction-detail-label">Tanggal</span>
                                <span class="transaction-detail-value">: {{ $transaksi->tanggal_format }}</span>
                            </div>
                        @endif

                        @if($transaksi->lokasi)
                            <div class="transaction-detail-item">
                                <span class="transaction-detail-label">Lokasi Detail</span>
                                <span class="transaction-detail-value">: {{ $transaksi->lokasi }}</span>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        @if($transaksi->status === 'pending')
                            <div class="mt-3 pt-3 border-top border-secondary">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-light btn-sm"
                                        onclick="cancelTransaction({{ $transaksi->id }})">
                                        <i class="bi bi-x-circle"></i> Batalkan
                                    </button>
                                    @if($transaksi->bukti_foto)
                                        <button class="btn btn-outline-light btn-sm"
                                            onclick="viewPhoto('{{ asset('storage/' . $transaksi->bukti_foto) }}')">
                                            <i class="bi bi-image"></i> Lihat Foto
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="content-box">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h4>Belum ada transaksi</h4>
                            <p class="text-light">Anda belum memiliki transaksi sampah. Mulai dengan membuat transaksi baru.
                            </p>
                            <div class="mt-3">
                                <a href="{{ url('/Buangsampah') }}" class="btn btn-light me-2">
                                    <i class="bi bi-plus-circle"></i> Antar Sampah
                                </a>
                                <a href="{{ url('/Jemput') }}" class="btn btn-outline-light">
                                    <i class="bi bi-truck"></i> Jemput Sampah
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal untuk melihat foto -->
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="photoPreview" src="" class="img-fluid" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER Full Width -->
    <footer class="w-100">
        @include('Footer')
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openChat() {
            // Implementasi chat picker
            alert('Fitur chat picker akan segera tersedia!');
        }

        function viewPhoto(photoUrl) {
            document.getElementById('photoPreview').src = photoUrl;
            new bootstrap.Modal(document.getElementById('photoModal')).show();
        }

        function cancelTransaction(id) {
            if (confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
                // Submit form untuk cancel
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/transaksi/${id}/cancel`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Auto hide alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

</body>

</html>