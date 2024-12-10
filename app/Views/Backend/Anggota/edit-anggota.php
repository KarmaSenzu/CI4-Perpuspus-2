<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Anggota</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Anggota</li>
                <li class="breadcrumb-item active">Edit Anggota</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Anggota</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/update-data-anggota'); ?>" class="row g-3">
                    <input type="hidden" name="id_anggota" value="<?= isset($data_anggota['id_anggota']) ? $data_anggota['id_anggota'] : ''; ?>">

                    <div class="col-md-6">
    <label for="id_anggota" class="form-label">ID Anggota</label>
    <input type="text" name="id_anggota" class="form-control" id="id_anggota" value="<?= isset($data_anggota['id_anggota']) ? $data_anggota['id_anggota'] : ''; ?>" disabled>
</div>


                    <div class="col-md-6">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <input type="text" name="nama_anggota" class="form-control" id="nama_anggota" value="<?= isset($data_anggota['nama_anggota']) ? $data_anggota['nama_anggota'] : ''; ?>" required>
                    </div>

                    <div class="col-md-6">
    <label class="form-label">Jenis Kelamin</label>
    <div class="d-flex align-items-center">
        <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_laki" value="L" <?= isset($data_anggota['jenis_kelamin']) && $data_anggota['jenis_kelamin'] == 'L' ? 'checked' : ''; ?> required>
            <label class="form-check-label" for="jenis_kelamin_laki">
                Laki-Laki
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="P" <?= isset($data_anggota['jenis_kelamin']) && $data_anggota['jenis_kelamin'] == 'P' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="jenis_kelamin_perempuan">
                Perempuan
            </label>
        </div>
    </div>
</div>

                    <div class="col-md-6">
                        <label for="no_tlp" class="form-label">No Telepon</label>
                        <input type="text" name="no_tlp" class="form-control" id="no_tlp" value="<?= isset($data_anggota['no_tlp']) ? $data_anggota['no_tlp'] : ''; ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" required><?= isset($data_anggota['alamat']) ? $data_anggota['alamat'] : ''; ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= isset($data_anggota['email']) ? $data_anggota['email'] : ''; ?>" required>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" value="1" id="change_password" name="change_password">
        <label class="form-check-label ms-2" for="change_password">
            Ubah Password
        </label>
    </div>
</div>

<div id="password_fields" class="col-md-12" style="display: none;">
    <div class="card mt-3">
        <div class="card-body">
            <h6 class="card-title">Password Baru</h6>
            <div class="form-group mb-3">
                <label for="password_anggota" class="form-label">Masukkan Password Baru</label>
                <input type="password" name="password_anggota" class="form-control" id="password_anggota" required>
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
            </div>
            <div id="password_error" class="text-danger" style="display: none;">Password dan Konfirmasi Password harus sama.</div>
        </div>
    </div>
</div>



                    <div class="col-12 text-left d-flex align-items-left justify-content-left">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="<?= base_url('admin/master-data-anggota'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>
    </div><!--/.row-->
</main><!--/.main-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const changePasswordSwitch = document.getElementById('change_password');
        const passwordFields = document.getElementById('password_fields');
        const passwordInput = document.getElementById('password_anggota');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordError = document.getElementById('password_error');

        changePasswordSwitch.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
                clearError();
            }
        });

        function clearError() {
            passwordError.style.display = 'none';
            passwordInput.value = '';
            confirmPasswordInput.value = '';
        }

        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            if (changePasswordSwitch.checked && passwordInput.value !== confirmPasswordInput.value) {
                event.preventDefault();
                passwordError.style.display = 'block';
            }
        });
    });
</script>



