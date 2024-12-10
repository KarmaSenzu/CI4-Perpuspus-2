<main id="main" class="main">
  <div class="pagetitle">
    <h1>Buku</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item">Buku</li>
        <li class="breadcrumb-item active">Detail Buku</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!-- Bagian Cover Buku, Judul, Tahun, dan Pengarang -->
  <div class="container mt-4">
    <div class="row bg-white p-4 rounded border shadow">
      <div class="col-md-12 mb-4">
        <h3 class="fw-bold text-center">Detail Buku</h3>
        <hr>
      </div>

      <!-- Kolom untuk Cover Buku -->
      <div class="col-md-4 text-center mb-4 mb-md-0">
        <a href="/assets/Cover_buku/<?= $buku['cover_buku']; ?>" target="_blank">
          <img src="/assets/Cover_buku/<?= $buku['cover_buku']; ?>" alt="Cover Buku" 
               class="img-fluid" style="max-width: 250px; border: 2px solid #ddd; border-radius: 10px;">
        </a>
      </div>

      <!-- Kolom untuk Judul, Tahun, dan Pengarang -->
      <div class="col-md-8">
        <!-- Flexbox untuk Judul Buku dan Tahun Terbit -->
        <div class="d-flex flex-column mb-4">
          <h2 class="fw-bold"><?= $buku['judul_buku']; ?> <span class="text-muted">(<?= $buku['tahun']; ?>)</span></h2>
          <p class="text-muted"><?= $buku['pengarang']; ?></p>
        </div>

        <!-- Bagian Deskripsi Buku -->
        <div class="bg-light p-4 rounded shadow-sm mb-4" style="margin-top: -20px;">
          <h5 class="fw-bold">Deskripsi</h5>
          <p><?= nl2br(htmlspecialchars($buku['keterangan'])); ?></p>
        </div>
      </div>
    </div>

    <!-- Bagian Informasi Buku -->
    <div class="row mt-4 bg-white p-4 rounded shadow">
      <div class="col-md-12">
        <h5 class="fw-bold">Informasi Buku</h5>
        <div class="row">
          <!-- Kolom untuk Penerbit dan ISBN -->
          <div class="col-md-6 mb-3">
            <h6 class="text-black-50"><b>Penerbit</b></h6>
            <p><?= isset($buku['penerbit']) ? $buku['penerbit'] : 'Data tidak tersedia'; ?></p>
          </div>
          <div class="col-md-6 mb-3">
            <h6 class="text-black-50"><b>ISBN</b></h6>
            <p><?= isset($buku['isbn']) ? $buku['isbn'] : 'Data tidak tersedia'; ?></p>
          </div>
          
          <!-- Kolom untuk Kategori dan Rak -->
          <div class="col-md-6 mb-3">
            <h6 class="text-black-50"><b>Kategori</b></h6>
            <p><?= isset($buku['nama_kategori']) ? $buku['nama_kategori'] : 'Data tidak tersedia'; ?></p>
          </div>
          <div class="col-md-6 mb-3">
            <h6 class="text-black-50"><b>Rak</b></h6>
            <p><?= isset($buku['nama_rak']) ? $buku['nama_rak'] : 'Data tidak tersedia'; ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-front mt-4">
        <a href="<?= base_url('user/buku'); ?>" class="btn btn-secondary me-2">Kembali</a>
    </div>
  </div>
</main>
