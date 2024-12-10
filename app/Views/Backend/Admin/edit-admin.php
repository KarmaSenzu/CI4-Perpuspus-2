<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="master-data-admin">Admin</a></li>
                <li class="breadcrumb-item active">Edit Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Admin</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/update-data-admin/' . $admin['id_admin']); ?>" class="row g-3" onsubmit="return validateForm()">
                    <input type="hidden" name="id_admin" value="<?= $admin['id_admin']; ?>">

                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Admin</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="<?= $admin['nama_admin']; ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="form-label">Username Admin</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control" id="username" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" value="<?= $admin['username_admin']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Ubah Password <small class="text-muted">(Biarkan kosong jika tidak ingin mengubah)</small></label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>

                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    </div>

                    <div class="col-md-6">
                        <label for="level" class="form-label">Jabatan</label>
                        <select name="level" class="form-select" id="level" required>
                            <option value="" disabled>-- Pilih Jabatan --</option>
                            <option value="1" <?= $admin['akses_level'] == '1' ? 'selected' : ''; ?>>Kepala Perpustakaan</option>
                            <option value="2" <?= $admin['akses_level'] == '2' ? 'selected' : ''; ?>>Admin Perpustakaan</option>
                        </select>
                    </div>

                    <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="<?= base_url('admin/master-data-admin'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Multi Columns Form -->

                <script>
                    function validateForm() {
                        var password = document.getElementById("password").value;
                        var confirmPassword = document.getElementById("confirm_password").value;

                        if (password !== confirmPassword) {
                            Swal.fire({
                                title: "Konfirmasi Password Salah!",
                                text: "Password dan Konfirmasi Password tidak sama.",
                                icon: "error",
                                confirmButtonColor: "#012970",
                                confirmButtonText: "OK"
                            });
                            return false;
                        }
                        return true;
                    }
                </script>


            </div>
        </div>
    </div>
</main>
