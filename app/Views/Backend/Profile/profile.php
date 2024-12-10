  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
          <li class="breadcrumb-item">Admin</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="<?= base_url('assets/profile/' . ($admin['profile_image'] ?? 'default.jpg')); ?>" alt="Profile" class="rounded-circle">
                    <h2><?= esc($admin['nama_admin']); ?></h2>
                    <?php if ($admin['akses_level'] == 1): ?>
                        <h3>Kepala Perpustakaan</h3>
                    <?php elseif ($admin['akses_level'] == 2): ?>
                        <h3>Admin Perpustakaan</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                </li>

              </ul>
              
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                  <h5 class="card-title">Detail Profile</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama Admin</div>
                    <div class="col-lg-9 col-md-8"><?= esc($admin['nama_admin']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Username Admin</div>
                    <div class="col-lg-9 col-md-8"><?= esc($admin['username_admin']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jabatan</div>
                    <div class="col-lg-9 col-md-8"><?= getJabatan($admin['akses_level']); ?></div>
                  </div>

                </div>
                <?php
function getJabatan($akses_level) {
    switch ($akses_level) {
        case 1:
            return "Kepala Perpustakaan";
        case 2:
            return "Admin Perpustakaan";
        default:
            return "Unknown";
    }
}

?>
                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="<?= base_url('admin/update-profile'); ?>" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
    <div class="col-md-8 col-lg-9">
    <img src="<?= base_url('assets/profile/' . ($admin['profile_image'] ?? 'default.jpg')); ?>" alt="Profile" class="rounded-circle">
        <div class="pt-2">
            <input type="file" name="profile_image" class="form-control" id="profileImage" accept="image/*">
        </div>
    </div>
</div>

                                    <div class="row mb-3">
                                        <label for="namaAdmin" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="nama_admin" type="text" class="form-control" id="namaAdmin" value="<?= esc($admin['nama_admin']); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="usernameAdmin" class="col-md-4 col-lg-3 col-form-label">Username Admin</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="username_admin" type="text" class="form-control" id="usernameAdmin" value="<?= esc($admin['username_admin']); ?>">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>


                <div class="tab-pane fade pt-3" id="profile-change-password">
    <!-- Change Password Form -->
    <form action="<?= base_url('admin/update-password'); ?>" method="post">
        <div class="row mb-3">
            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
            <div class="col-md-8 col-lg-9">
                <input name="new_password" type="password" class="form-control" id="newPassword" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password Baru</label>
            <div class="col-md-8 col-lg-9">
                <input name="confirm_password" type="password" class="form-control" id="confirmPassword" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </div>
    </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../../assets/vendor/quill/quill.js"></script>
  <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>

</body>

</html>