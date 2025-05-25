<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Faktur Transaksi - TrashForCash</title>
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
                    <h5>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</h5>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="nav-link active" href="{{ route('admin.transaksi.index') }}">Faktur Transaksi</a>
                    <a class="nav-link" href="{{ route('admin.transaksi.riwayat') }}">Riwayat Transaksi</a>
                    <a class="nav-link" href="{{ route('admin.kelolauser') }}">Kelola User</a>

                </nav>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 p-5">
                <div class="mb-4 py-2 px-3 text-white fw-bold text-center"
                    style="background-color: #244b36; border-radius: 8px; width: 100%;">
                    Faktur Transaksi
                </div>

                <div class="p-4" style="background-color: #244b36; border-radius: 8px;">
                    <!-- Search + Controls -->
                    <div class="d-flex justify-content-between align-items-center mb-3 text-white">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Menampilkan</label>
                            <select class="form-select form-select-sm w-auto" aria-label="Jumlah kolom">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                            </select>
                            <span class="ms-2">kolom</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <label class="me-2">Nama</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Cari...">
                            <button class="btn btn-light btn-sm ms-2">Cari</button>
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="table table-bordered bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tipe Transaksi</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->user->name ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $data->alamat }}</td>
                                    <td>{{ $data->layanan }}</td>
                                    <td>
                                        @if ($data->status === 'pending')
                                            <form action="{{ route('admin.transaksi.verifikasi', $data->id) }}" method="POST"
                                                onsubmit="return confirm('Verifikasi transaksi ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-dark btn-sm">Verifikasi</button>
                                            </form>
                                        @elseif ($data->status === 'completed')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @elseif ($data->status === 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge bg-secondary">Status Tidak Dikenal</span>
                                        @endif
                                    </td>
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