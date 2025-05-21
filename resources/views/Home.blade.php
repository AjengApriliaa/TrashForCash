@extends('footer')

@section('content')
<header style="background-color: #254d2e;" class="text-white p-4">
    <div class="container d-flex justify-content-between align-items-center">
      <img src="{{ asset('asset/tfc-logo-light1.svg.svg') }}" alt="Logo TrashForCash" style="height: 70px;" class="img-fluid">

        <nav>
            <a href="/" class="text-white me-3">Home</a>
            <a href="#tentang" class="text-white me-3">Profil</a>
            <a href="#kontak" class="text-white me-3">Kontak</a>
            <a href="#footer" class="text-white">Hubungi Kami</a>
        </nav>
    </div>
</header>


<!-- Hero Section -->
<section class="text-white" style="background-color: #254d2e; padding: 60px 0;">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
        <div class="col-md-6">
            <h1 class="fw-bold">Selamat Datang di TrashForCash</h1>
            <p>Solusi Terbaik untuk Pengelolaan Sampah yang Berkelanjutan!</p>
            <a href="{{ url('Login') }}" class="btn btn-primary">Start</a>
        </div>
        <div class="col-md-5 text-center">
            <img src="{{ asset('asset/Group 8748.png') }}" class="img-fluid" alt="Ilustrasi">
        </div>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-5 text-center">
    <div class="container">
        <h2 class="text-success fw-bold">TENTANG APLIKASI</h2>
        <p>TrashForCash adalah platform yang bertujuan untuk membantu Anda mengelola sampah dengan cara yang lebih berkelanjutan dan menguntungkan. Dengan TrashForCash, Anda dapat dengan mudah mendaur ulang sampah Anda tanpa ribet. Kami menyediakan fasilitas untuk memasukkan jenis dan berat sampah Anda, dan dalam sekejap, Anda akan mendapatkan insentif berupa koin yang dapat ditukar dengan uang tunai.

Kami percaya bahwa berkontribusi pada lingkungan yang lebih baik haruslah menjadi pengalaman yang mudah dan bermanfaat bagi semua orang. Dengan TrashForCash, Anda tidak hanya membantu mengurangi limbah yang mencemari lingkungan, tetapi juga memiliki kesempatan untuk mendapatkan manfaat dari upaya Anda.</p>
    </div>
</section>

<!-- Visi Misi -->
<section class="bg-light py-5">
    <div class="container d-flex justify-content-between flex-wrap">
        <div class="col-md-5">
            <h4 class="fw-bold">VISI</h4>
            <ul>
                <li>Menjadi sumber utama pengetahuan, solusi, dan insentif untuk pengelolaan sampah yang berkelanjutan secara global.</li>
                <li>Memberikan informasi edukatif yang mudah diakses tentang pentingnya pengelolaan sampah yang baik terhadap lingkungan dan cara melakukan pemilahan serta mendaur ulang yang benar..</li>
            </ul>
        </div>
        <div class="col-md-5">
            <h4 class="fw-bold">MISI</h4>
            <ul>
                <li>Mendorong partisipasi aktif dari masyarakat dalam upaya pengelolaan sampah yang lebih baik melalui komunitas online dan offline.
</li>
                <li>Berkolaborasi dengan organisasi lingkungan, pemerintah, dan bisnis untuk memajukan praktik pengelolaan sampah yang berkelanjutan dan meningkatkan kesadaran akan masalah lingkungan.
</li>
            </ul>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <!-- Gambar kiri -->
            <div class="col-md-6 text-center">
                <img src="{{ asset('asset/2-removebg-preview 1.png') }}" alt="Ilustrasi Kerja" class="img-fluid" style="max-width: 100%;">
            </div>

            <!-- Langkah-langkah kanan -->
            <div class="col-md-6">
                <h2 class="text-success fw-bold mb-4">Bagaimana kami bekerja?</h2>
                <ol>
                    <li>Registrasi dan Pembuatan Akun Pengguna</li>
                    <li>Penjemputan Sampah dari Pengguna</li>
                    <li>Penimbangan dan Perhitungan Insentif</li>
                    <li>Penukaran Poin atau Nilai Sampah</li>
                    <li>Pengelolaan Sampah Berkelanjutan</li>
                    <li>Peningkatan Berkelanjutan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Langkah Proses (6 Ikon Manual) -->
<section class="py-5" style="background-color: #254d2e;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">

            @for ($i = 1; $i <= 6; $i++)
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="rounded-circle border border-white d-flex justify-content-center align-items-center mb-2"
                         style="width: 80px; height: 80px;">
                        <img src="{{ asset('asset/' . ($i == 1 ? 'Group 8745.svg' : 'Group (' . ($i - 2) . ').svg')) }}"
                             alt="Step {{ $i }}" style="width: 40px;">
                    </div>
                    <span class="position-absolute top-0 translate-middle badge rounded-pill bg-white"
                          style="left: 50%; transform: translateX(-50%) translateY(-50%); font-size: 12px;">
                        {{ $i }}
                    </span>
                </div>

                @if ($i < 6)
                    <div class="flex-grow-1 border-top border-white mx-2" style="height: 2px;"></div>
                @endif
            @endfor

        </div>
    </div>
</section>


<!-- Kontak -->
<section id="kontak" class="py-5 text-center bg-white">
    <div class="container">
        <p>"Jangkauan bank sampah yang luas merubah sampah menjadi sumber daya berharga."</p>
        <p class="fw-semibold">📍 Lampung, Bandar Lampung, Indonesia</p>
        <p>📞 (123) 456-78-90 | 📧 info@website.com</p>
        <img src="{{ asset('asset/Group 8746.png') }}" alt="Peta Dunia" class="img-fluid" style="max-width: 700px;">
    </div>
</section>
@endsection
