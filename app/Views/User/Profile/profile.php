<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="<?= base_url('assets/profile/' . ($user['profile_image'] ?? 'default.jpg')); ?>" alt="Profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        <h2><?= esc($user['nama_anggota']); ?></h2>
                        <h3>Anggota Perpustakaan</h3>
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
                                    <div class="col-lg-3 col-md-4 label">Nama</div>
                                    <div class="col-lg-9 col-md-8"><?= esc($user['nama_anggota']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php
                                        $jenis_kelamin = esc($user['jenis_kelamin']);
                                        if ($jenis_kelamin == 'L') {
                                            echo 'Laki-laki';
                                        } elseif ($jenis_kelamin == 'P') {
                                            echo 'Perempuan';
                                        } else {
                                            echo 'Unknown';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nomor Telepon</div>
                                    <div class="col-lg-9 col-md-8"><?= esc($user['no_tlp']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= esc($user['email']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8"><?= esc($user['alamat']); ?></div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    <!-- Profile Edit Form -->
    <form action="<?= base_url('user/update-profile'); ?>" method="post" enctype="multipart/form-data">
        <!-- Profile Image Section -->
        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
            <div class="col-md-8 col-lg-9">
                <!-- Display current profile image -->
                <img src="<?= base_url('assets/profile/' . ($user['profile_image'] ?? 'default.jpg')); ?>" alt="Profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                <div class="pt-2">
                    <input type="file" name="profile_image" class="form-control" id="profileImage" accept="image/*">
                </div>
            </div>
        </div>

        <!-- Other Profile Fields -->
        <div class="row mb-3">
            <label for="namaAnggota" class="col-md-4 col-lg-3 col-form-label">Nama</label>
            <div class="col-md-8 col-lg-9">
                <input name="nama_anggota" type="text" class="form-control" id="namaAnggota" value="<?= esc($user['nama_anggota']); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="jenisKelamin" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
            <div class="col-md-8 col-lg-9">
                <select name="jenis_kelamin" id="jenisKelamin" class="form-select">
                    <option value="L" <?= ($user['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= ($user['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="nomorTelepon" class="col-md-4 col-lg-3 col-form-label">Nomor Telepon</label>
            <div class="col-md-8 col-lg-9">
                <input name="no_tlp" type="text" class="form-control" id="nomorTelepon" value="<?= esc($user['no_tlp']); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
            <div class="col-md-8 col-lg-9">
                <input name="email" type="email" class="form-control" id="email" value="<?= esc($user['email']); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
            <div class="col-md-8 col-lg-9">
                <textarea name="alamat" class="form-control" id="alamat" style="height: 100px"><?= esc($user['alamat']); ?></textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form><!-- End Profile Edit Form -->
</div>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
    <!-- Change Password Form -->
    <form action="<?= base_url('user/update-password'); ?>" method="post">
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

 <script>
        <?php if (session()->getFlashdata('error')): ?>
            alert("<?php echo session()->getFlashdata('error'); ?>");
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            alert("<?php echo session()->getFlashdata('success'); ?>");
        <?php endif; ?>
    </script>
