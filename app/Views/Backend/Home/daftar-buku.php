<body>

  <!-- Page Title -->
  <div class="pagetitle">
    <h1>Daftar Buku</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Pages</li>
        <li class="breadcrumb-item active">Daftar Buku</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <!-- Book List Section -->
  <section class="section">
    <h3 class="section-title" data-aos="fade-up">Daftar Buku</h3>
    <div class="row">
      <?php 
      usort($bukuList, function($a, $b) {
          return $b['tahun'] - $a['tahun'];
      });

      foreach ($bukuList as $buku): ?>
        <div class="col-md-4 mb-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm">
            <img src="assets/Cover_buku/<?= $buku['cover_buku'] ?>" class="card-img-top" alt="<?= $buku['judul_buku'] ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= $buku['judul_buku'] ?> (<?= $buku['tahun'] ?>)</h5>
              <p class="card-text text-muted"><?= $buku['keterangan'] ?></p>

              <!-- Borrow Button -->
              <div class="mt-auto">
                <?php if (!session()->get('is_logged_in')): ?>
                  <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Pinjam Buku</button>
                <?php else: ?>
                  <a href="<?= site_url('user/peminjaman-step1/' . $buku['id']) ?>" class="btn btn-outline-primary w-100">Pinjam Buku</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <!-- End Book List Section -->

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login Dulu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Anda harus login terlebih dahulu untuk melakukan peminjaman buku.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <a href="<?= site_url('user/login-user'); ?>" class="btn btn-outline-primary">Login</a>
        </div>
      </div>
    </div>
  </div>
  <!-- End Login Modal -->

</body>
