<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Anggota</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Anggota</li>
                <li class="breadcrumb-item active">Input Anggota</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Input Anggota</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/simpan-data-anggota'); ?>" class="row g-3">
                    <div class="col-md-12">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <input type="text" name="nama_anggota" class="form-control" id="nama_anggota" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_L" value="L" required>
                                <label class="form-check-label" for="jenis_kelamin_L">
                                    Laki-Laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_P" value="P" required>
                                <label class="form-check-label" for="jenis_kelamin_P">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="no_tlp" class="form-label">No Telepon</label>
                        <input type="text" name="no_tlp" class="form-control" id="no_tlp" required>
                    </div>

                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="col-md-6">
                        <label for="password_anggota" class="form-label">Password</label>
                        <input type="password" name="password_anggota" class="form-control" id="password_anggota" required>
                    </div>

                    <div class="col-12 text-left d-flex align-items-left justify-content-left">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="<?= base_url('admin/master-data-anggota'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>
    </div>
</main>
