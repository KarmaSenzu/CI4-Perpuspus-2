<main id="main" class="main">
    <div class="pagetitle">
    <h1>Master Data Rak</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Rak</li>
                <li class="breadcrumb-item active">Edit Rak</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Rak</h5>

                <!-- Form -->
                <form method="post" action="<?= base_url('admin/update-data-rak'); ?>" class="row g-3">
                    <!-- ID Rak (Read-Only) -->
                    <div class="row mb-3">
                        <label for="id_rak" class="col-sm-2 col-form-label">ID Rak</label>
                        <div class="col-sm-10">
                            <input type="text" name="id_rak" class="form-control" id="id_rak" value="<?= isset($data_rak['id_rak']) ? $data_rak['id_rak'] : ''; ?>" disabled>
                        </div>
                    </div>

                    <!-- Nama Rak -->
                    <div class="row mb-3">
                        <label for="nama_rak" class="col-sm-2 col-form-label">Nama Rak</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_rak" class="form-control" id="nama_rak" value="<?= isset($data_rak['nama_rak']) ? $data_rak['nama_rak'] : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 text-left d-flex align-items-left justify-content-left">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="<?= base_url('admin/master-data-rak'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Form -->

            </div>
        </div>
    </div><!--/.row-->
</main><!--/.main-->
