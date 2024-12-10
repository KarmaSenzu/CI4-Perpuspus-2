<main id="main" class="main">
    <div class="pagetitle">
        <h1>Master Data Kategori</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Kategori</li>
                <li class="breadcrumb-item active">Input Kategori</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Input Kategori</h5>

                <!-- Multi Columns Form -->
                <form method="post" action="<?= base_url('admin/simpan-data-kategori'); ?>" class="row g-3">
                    <div class="col-md-12">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" required>
                    </div>

                    <div class="col-12 text-left d-flex align-items-left justify-content-left">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="<?= base_url('admin/master-data-kategori'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>
    </div><!--/.row-->
</main><!--/.main-->
