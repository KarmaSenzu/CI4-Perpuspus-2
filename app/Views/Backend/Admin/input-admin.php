<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active">Input Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 mx-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Input Admin</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/simpan-data-admin'); ?>" class="row g-3" onsubmit="return validateForm()">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Admin</label>
                        <input type="text" name="nama" class="form-control" id="nama" required>
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="form-label">Username Admin</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control" id="username" onkeypress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>

                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>

                    <div class="col-md-6">
                        <label for="level" class="form-label">Jabatan</label>
                        <select name="level" class="form-select" id="level" required>
                            <option value="" disabled selected>-- Pilih Jabatan --</option>
                            <option value="1">Kepala Perpustakaan</option>
                            <option value="2">Admin Perpustakaan</option>
                        </select>
                    </div>

                    <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
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

<!-- SweetAlert Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
