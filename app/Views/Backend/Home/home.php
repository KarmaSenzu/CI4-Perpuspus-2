<body>
<section class="hero d-flex align-items-center" style="background: url('assets/img/hero.jpg') no-repeat center; background-size: cover; height: 90vh;">
  <div class="container text-center" data-aos="fade-up" style="color: black;">
    <h1 class="display-4">Selamat Datang di Perpuspus</h1>
    <p class="lead">Jelajahi ribuan buku dan temukan cerita yang menginspirasi hidup Anda.</p>
    <a href="user/login-user" class="btn btn-outline-dark btn-lg mt-3">Jelajahi Sekarang</a>
  </div>
</section>


<!-- Main Content -->
<!-- <main class="container my-5">
<h2 class="welcome-title" data-aos="fade-up">Selamat Datang di Perpuspus</h2>
<p class="welcome-subtitle" data-aos="fade-up" data-aos-delay="200">"Di perpustakaan, setiap halaman adalah perjalanan, setiap buku adalah dunia, dan setiap pembaca adalah penjelajah."</p>
-->

<main class="container my-5">
  <section class="stats my-5 py-5 bg-light">
  <div class="container">
    <div class="row text-center">
      <!-- Menampilkan jumlah Buku -->
      <div class="col-md-3" data-aos="fade-up">
        <h2 class="text-primary"><?= $jumlahBuku ?></h2>
        <p>Judul Buku Tersedia</p>
      </div>

      <!-- Menampilkan jumlah Anggota -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-primary"><?= $jumlahAnggota ?></h2>
        <p>Anggota Aktif</p>
      </div>

      <!-- Menampilkan jumlah Kategori -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <h2 class="text-primary"><?= $jumlahKategori ?></h2>
        <p>Kategori Buku</p>
      </div>

      <!-- Menampilkan jumlah Rak -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="600">
        <h2 class="text-primary"><?= $jumlahRak ?></h2>
        <p>Rak Buku</p>
      </div>
    </div>
  </div>
</section>

<section class="about-us py-5 bg-light">
  <div class="container">
    <h3 class="section-title text-center mb-5" data-aos="fade-up">Tentang Kami</h3>
    <div class="row g-4 align-items-center">
      <!-- Kolom Misi -->
      <div class="col-md-4" data-aos="fade-up">
        <div class="text-center">
          <h4 class="text-dark mb-3">Misi Kami</h4>
          <p>Kami berkomitmen untuk menyediakan akses tanpa batas ke ilmu pengetahuan, inspirasi, dan hiburan melalui koleksi buku yang beragam.</p>
        </div>
      </div>

      <!-- Kolom Visi -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="text-center">
          <h4 class="text-dark mb-3">Visi Kami</h4>
          <p>Menjadi perpustakaan terkemuka yang memajukan literasi dan pembelajaran bagi komunitas lokal maupun global.</p>
        </div>
      </div>

      <!-- Kolom Layanan -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
        <div class="text-center">
          <h4 class="text-dark mb-3">Layanan Kami</h4>
          <p>Kami menawarkan berbagai layanan, mulai dari koleksi fisik hingga digital, ruang baca yang nyaman, dan kegiatan literasi yang inspiratif.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="gallery py-5">
  <div class="container">
    <h3 class="section-title" data-aos="fade-up">Galeri Aktivitas</h3>
    <div class="row">
      <div class="col-md-4 mb-4" data-aos="zoom-in">
        <img src="assets/img/slides-1.jpg" class="img-fluid rounded shadow-sm" alt="Activity 1">
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
        <img src="assets/img/slides-2.jpg" class="img-fluid rounded shadow-sm" alt="Activity 2">
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="400">
        <img src="assets/img/slides-3.jpg" class="img-fluid rounded shadow-sm" alt="Activity 3">
      </div>
    </div>
  </div>
</section>
</main>
</body>
