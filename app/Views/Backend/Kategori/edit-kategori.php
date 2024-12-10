<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Kategori</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Kategori</li>
                <li class="breadcrumb-item active">Edit Kategori</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Kategori</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/update-data-kategori'); ?>" class="row g-3">
                    <!-- ID Kategori (Read-Only) -->
                    <div class="row mb-3">
                        <label for="id_kategori" class="col-sm-2 col-form-label">ID Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" name="id_kategori" class="form-control" id="id_kategori" value="<?= isset($data_kategori['id_kategori']) ? $data_kategori['id_kategori'] : ''; ?>" disabled>
                        </div>
                    </div>

                    <!-- Nama Kategori -->
                    <div class="row mb-3">
                        <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="<?= isset($data_kategori['nama_kategori']) ? $data_kategori['nama_kategori'] : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 text-left d-flex align-items-left justify-content-left">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="<?= base_url('admin/master-data-kategori'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>
    </div><!--/.row-->
</main><!--/.main-->
