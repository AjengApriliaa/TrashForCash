<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body style="font-family: 'Poppins', sans-serif;">

    @yield('content')

    <footer style="background-color: #254d2e;" class="text-white pt-5 pb-3" id="footer">
        <div class="container">
            <div class="row align-items-start">

                <!-- Kolom Logo & Layanan (logo + daftar vertikal) -->
                <div class="col-md-4 mb-4 d-flex align-items-start">
                    <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="TrashForCash Logo"
                        style="height: 50px;">
                    <ul class="list-unstyled ms-3" style="font-size: 14px;">
                        <li><a href="#" class="text-white text-decoration-none">Bantuan</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Notifikasi</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Kontak Kami</a></li>
                    </ul>
                </div>

                <!-- Kolom Ikon Medsos -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Ikuti Kami</h6>
                    <div class="d-flex mt-2">
                        <img src="{{ asset('asset/facebook.webp') }}" class="me-2" style="width: 24px;">
                        <img src="{{ asset('asset/Instagram.png') }}" class="me-2" style="width: 24px;">
                        <img src="{{ asset('asset/twitter.webp') }}" class="me-2" style="width: 24px;">
                        <img src="{{ asset('asset/linkedin.png') }}" class="me-2" style="width: 24px;">
                        <img src="{{ asset('asset/youtube.webp') }}" style="width: 24px;">
                    </div>
                </div>

                <!-- Kolom Pencarian -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Pencarian</h6>
                    <form class="d-flex mt-2">
                        <input type="text" class="form-control" placeholder="Cari..." style="max-width: 200px;">
                        <button class="btn btn-outline-light ms-2" type="submit">Cari</button>
                    </form>
                </div>

            </div>

            <hr class="border-light">

            <!-- Link Bawah -->
            <div class="row">
                <div class="col text-center">
                    <a href="#" class="text-white mx-2 text-decoration-none">Tentang Aplikasi</a>
                    <a href="#" class="text-white mx-2 text-decoration-none">Hubungi Kami</a>
                    <a href="#" class="text-white mx-2 text-decoration-none">Kebijakan Privasi</a>
                </div>
            </div>

            <div class="text-center mt-3" style="font-size: 13px;">
                &copy; {{ date('Y') }} TrashForCash. Semua hak dilindungi.
            </div>
        </div>
    </footer>

</body>

</html>