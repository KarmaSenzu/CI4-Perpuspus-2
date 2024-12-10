<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Perpuspus</title>

  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo.png" rel="logo">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../../assets/css/style.css" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="<?= base_url('home'); ?>" class="logo d-flex align-items-center w-auto">
                  <img src="../../assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Perpuspus</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Daftar Sebagai Anggota</h5>
                    <p class="text-center small">Masukkan data diri anda untuk menjadi anggota</p>
                  </div>

                  <form action="<?= base_url('user/proses-registrasi'); ?>" method="post" class="row g-3 needs-validation" novalidate>
                    <!-- Nama input -->
                    <div class="col-md-6">
                      <label for="yourName" class="form-label">Nama Anda</label>
                      <input type="text" name="nama_anggota" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Tolong, Masukkan nama anda!</div>
                    </div>

                    <!-- Jenis Kelamin input -->
                    <div class="col-md-6">
                      <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                      <select class="form-control" name="jenis_kelamin" id="jenisKelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                      <div class="invalid-feedback">Pilih jenis kelamin anda!</div>
                    </div>

                    <!-- Email input -->
                    <div class="col-md-6">
                      <label for="yourEmail" class="form-label">Email Anda</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Tolong masukkan email valid dan belum digunakan anggota lain!</div>
                    </div>

                    <!-- No Telepon input -->
                    <div class="col-md-6">
                      <label for="yourPhone" class="form-label">Nomor Telepon</label>
                      <input type="text" name="no_tlp" class="form-control" id="yourPhone" required>
                      <div class="invalid-feedback">Masukkan nomor telepon anda!</div>
                    </div>

                    <!-- Password input -->
                    <div class="col-md-6">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password_anggota" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Tolong masukkan password anda!</div>
                    </div>

                    <!-- Konfirmasi Password input -->
                    <div class="col-md-6">
                      <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                      <input type="password" name="confirm_password" class="form-control" id="confirmPassword" required>
                      <div class="invalid-feedback">Tolong konfirmasi password anda!</div>
                    </div>

                    <!-- Alamat input -->
                    <div class="col-md-12">
                      <label for="yourAddress" class="form-label">Alamat Anda</label>
                      <textarea name="alamat" class="form-control" id="yourAddress" rows="3" required></textarea>
                      <div class="invalid-feedback">Masukkan alamat anda!</div>
                    </div>

                    <!-- Syarat dan Ketentuan -->
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">
                          Saya menyetujui dan menerima <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat dan Ketentuan</a>
                        </label>
                        <div class="invalid-feedback">Anda harus menyetujui Syarat dan Ketentuan terlebih dahulu.</div>
                      </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Daftar</button>
                    </div>

                    <!-- Login Link -->
                    <div class="col-12">
                      <p class="small mb-0">Sudah menjadi anggota? <a href="login-user">Ayo Login!</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>

    <!-- Modal Syarat dan Ketentuan -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul>
              <li>Peminjaman buku harus dikembalikan tepat waktu, jika tidak maka anggota akan dikenai denda.</li>
              <li>Anggota bertanggung jawab atas kerusakan atau kehilangan buku.</li>
              <li>Keanggotaan dapat dibekukan jika melanggar aturan perpustakaan.</li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

  </main>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/main.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: "<?php echo session()->getFlashdata('error'); ?>"
        });
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: "<?php echo session()->getFlashdata('success'); ?>"
        });
      <?php endif; ?>
    });
  </script>

</body>

</html>
