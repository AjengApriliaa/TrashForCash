<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail user - TrashForCash</title>
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

    <div class="container py-5">
        <h4 class="mb-4">Data Diri</h4>

        <div class="border rounded p-4" style="background-color: #f4fff0;">
            <h5 class="mb-3 fw-bold">Profil</h5>
            <p class="bg-success text-white p-2 rounded">
                Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun
            </p>

            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Panjang</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $user->telepon) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <input type="radio" name="gender" value="Laki-laki" {{ $user->gender === 'Laki-laki' ? 'checked' : '' }}> Laki-laki
                    <input type="radio" name="gender" value="Perempuan" {{ $user->gender === 'Perempuan' ? 'checked' : '' }}> Perempuan
                    <input type="radio" name="gender" value="Lainnya" {{ $user->gender === 'Lainnya' ? 'checked' : '' }}>
                    Lainnya
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                        class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
            </form>

            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
    </div>
    @include('Footer')
</body>

</html>