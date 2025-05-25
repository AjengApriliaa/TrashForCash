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

        .struk-card {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .header-green {
            background-color: #244b36;
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            margin-top: 1.5rem;
            border-bottom: 2px solid #244b36;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .data-row {
            margin-bottom: 0.5rem;
        }

        .footer-note {
            background-color: #244b36;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="struk-card">
        <div class="header-green">
            Struk Transaksi
        </div>

        {{-- Section: Data User --}}
        <div class="section-title">Informasi Pengguna</div>
        <div class="data-row"><strong>Nama:</strong> {{ $transaksi->user->name ?? 'Tidak Diketahui' }}</div>
        <div class="data-row"><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</div>

        {{-- Section: Detail Transaksi --}}
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
                <span class="text-secondary">Tidak Diketahui</span>
            @endif
        </div>
        <div class="data-row"><strong>Jenis Transaksi:</strong> {{ ucfirst($transaksi->tipe_transaksi) }}</div>

        {{-- Section: Lokasi --}}
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

        {{-- Section: Bukti Foto --}}
        @if ($transaksi->bukti_foto)
            <div class="section-title">Bukti Transaksi</div>
            <div class="text-center">
                <img src="{{ asset('storage/' . $transaksi->bukti_foto) }}" alt="Bukti Transaksi"
                    class="img-fluid rounded border" style="max-height: 300px;">
            </div>
        @endif

        {{-- Footer Note --}}
        <div class="footer-note mt-4">
            ( x ) Untuk Menutup Layanan
        </div>
    </div>

</body>

</html>