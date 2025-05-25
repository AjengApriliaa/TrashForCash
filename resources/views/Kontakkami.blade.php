<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kontak Kami - TrashForCash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #edfbc1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header dan navbar */
        .header {
            background-color: #244b36;
            color: white;
            font-size: 0.85rem;
            padding: 0.4rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: white;
            margin-right: 1rem;
            text-decoration: none;
        }

        .header a:last-child {
            margin-right: 0;
        }

        .logo-section {
            background-color: #244b36;
            display: flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            gap: 12px;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            line-height: 1.2;
            user-select: none;
        }

        .logo-section img {
            height: 40px;
            width: auto;
        }

        .search-form {
            margin-left: auto;
            max-width: 300px;
        }

        .search-form input {
            border-radius: 15px;
            border: none;
            padding-left: 12px;
            height: 33px;
            width: 100%;
            font-size: 0.9rem;
        }

        /* Wrapper utama konten */
        .main-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 40px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Bagian atas: Kembali dan Judul */
        .back-and-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 35px;
        }

        .back-link {
            font-size: 1.5rem;
            font-weight: 700;
            color: black;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            user-select: none;
            min-width: 115px;
            /* agar "Kembali" dan ikon punya ruang tetap */
        }

        .back-link i {
            font-size: 1.7rem;
        }

        .page-title {
            font-size: 1.7rem;
            font-weight: 700;
            user-select: none;
            white-space: nowrap;
        }

        /* Container form dan kontak */
        .content-container {
            display: flex;
            justify-content: center;
            gap: 80px;
        }

        /* Form kiri */
        .contact-form {
            width: 420px;
            display: flex;
            flex-direction: column;
        }

        .contact-form input,
        .contact-form textarea {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-weight: 700;
            font-size: 1rem;
            padding: 8px 12px;
            margin-bottom: 20px;
            resize: none;
        }

        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            font-weight: 700;
            color: #aaa;
        }

        .contact-form textarea {
            height: 140px;
            line-height: 1.3;
        }

        .btn-send {
            width: 160px;
            padding: 10px 0;
            font-weight: 700;
            font-size: 1rem;
            color: black;
            background-color: white;
            border: 1px solid #999;
            border-radius: 3px;
            cursor: pointer;
            align-self: flex-start;
            user-select: none;
            transition: background-color 0.3s ease;
        }

        .btn-send:hover {
            background-color: #e3e3e3;
        }

        /* Kontak kanan */
        .contact-info {
            width: 350px;
            display: flex;
            flex-direction: column;
            user-select: none;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 1rem;
        }

        .contact-item i {
            font-size: 1.3rem;
            min-width: 25px;
            text-align: center;
        }

        .divider {
            border-top: 1px solid #333;
            width: 150px;
            margin-bottom: 20px;
        }

        .social-icons {
            display: flex;
            gap: 20px;
            font-size: 1.3rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- Header atas -->
    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <div>
            <a href="Kontakkami">call center</a>
            <a href="Kontakkami">kontak kami</a>
        </div>
        <div>
            <a href="Notifikasi">Notifikasi</a>
            <a href="Bantuan">Bantuan</a>
            <a href="#">Bahasa Indonesia</a>
        </div>
    </div>

    <!-- Logo dan Search -->
    <div class="logo-section">
        <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="Logo TrashForCash" />
        Trash<br />ForCash
        <form class="search-form" role="search">
            <input type="search" placeholder="Cari" aria-label="Cari" />
        </form>
    </div>

    <!-- Konten utama -->
    <div class="main-wrapper">
        <div class="back-and-title">
            <a href="/dashboard" class="back-link"><i class="bi bi-arrow-left"></i> Kembali</a>
            <div class="page-title">Kontak Kami</div>
        </div>

        <div class="content-container">
            <form class="contact-form">
                <input type="text" placeholder="Nama" />
                <input type="email" placeholder="Email" />
                <textarea placeholder="Pesan"></textarea>
                <button type="submit" class="btn-send">Send</button>
            </form>

            <div class="contact-info">
                <div class="contact-item"><i class="bi bi-geo-alt-fill"></i>TrashForCash</div>
                <div class="contact-item"><i class="bi bi-telephone-fill"></i>+6281818181818</div>
                <div class="contact-item"><i class="bi bi-envelope-fill"></i>trashforcash@gmail.com</div>

                <div class="divider"></div>

                <div class="social-icons">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-linkedin"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-google"></i>
                    <i class="bi bi-youtube"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('Footer')
</body>

</html>