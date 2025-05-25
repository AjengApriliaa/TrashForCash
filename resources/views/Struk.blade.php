<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ecf8cd;
            font-family: 'Segoe UI', sans-serif;
        }

        .struk-wrapper {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            position: relative;
        }

        .header {
            background-color: #244b36;
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 2rem;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
        }

        .close-btn:hover {
            color: #ccc;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.2rem;
            color: #244b36;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #244b36;
            padding-bottom: 0.5rem;
        }

        .data-row {
            margin-bottom: 0.7rem;
            font-size: 1rem;
        }

        .footer-action {
            margin-top: 2.5rem;
            text-align: center;
        }

        .footer-action a {
            background-color: #244b36;
            color: white;
            padding: 0.8rem 2rem;
            font-weight: bold;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .footer-action a:hover {
            background-color: #1a3c2c;
        }

        .bukti-img {
            max-height: 300px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <div class="struk-wrapper">

        <div class="header">
            Struk Transaksi
            <a href="{{ url()->previous() }}" class="close-btn">&times;</a>
        </div>

        {{-- Informasi Pengguna --}}
        <div class="section-title">Informasi Pengguna</div>
        <div class="data-row"><strong>Nama:</strong> {{ $transaksi->user->name ?? 'Tidak Diketahui' }}</div>
        <div class="data-row"><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</div>

        {{-- Detail Transaksi --}}
        <div class="section-title">Detail Transaksi</div>
        <div class="data-row"><strong>ID Transaksi:</strong> {{ $transaksi->id }}</div>
        <div class="data-row"><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y, H:i') }}</div>
        <div class="data-row"><strong>Status:</strong>
            @if ($transaksi->status === 'completed')
                <span class="text-success fw-bold">Terverifikasi</span>
            @elseif ($transaksi->status === 'pending')
                <span class="text-warning fw-bold">Menunggu</span>
            @elseif ($transaksi->status === 'cancelled')
                <span class="text-danger fw-bold">Dibatalkan</span>
            @else
                <span class="text-muted">Tidak Diketahui</span>
            @endif
        </div>
        <div class="data-row"><strong>Jenis Transaksi:</strong> {{ ucfirst($transaksi->tipe_transaksi) }}</div>

        {{-- Lokasi --}}
        <div class="section-title">Alamat</div>
        <div class="data-row">
            <strong>
                @if($transaksi->tipe_transaksi === 'jemput')
                    Lokasi Jemput:
                @elseif($transaksi->tipe_transaksi === 'antar')
                    Lokasi Antar:
                @else
                    Lokasi:
                @endif
            </strong> {{ $transaksi->alamat }}
        </div>

        {{-- Bukti Transaksi --}}
        @if ($transaksi->bukti_foto)
            <div class="section-title">Bukti Transaksi</div>
            <div class="text-center">
                <img src="{{ asset('storage/' . $transaksi->bukti_foto) }}" class="img-fluid bukti-img"
                    alt="Bukti Transaksi">
            </div>
        @endif

        {{-- Footer --}}
        <div class="footer-action">
            <a href="{{ url()->previous() }}">( x ) Untuk Menutup Layanan</a>
        </div>

    </div>

</body>

</html>