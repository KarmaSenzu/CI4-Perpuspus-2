<main id="main" class="main">
<div class="pagetitle">
  <h1>Master Data Buku</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item">Buku</li>
      <li class="breadcrumb-item active">Edit Buku</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Edit Buku</h1>

    <div class="container bg-white mt-3 p-4 rounded shadow-sm border" style="max-width: 1000px;">
        <form method="post" action="<?= base_url('admin/update-data-buku/' . $data_edit['id_buku']); ?>" enctype="multipart/form-data">
            <div class="row">
                <!-- Gambar Sampul Buku -->
                <div class="col-md-4 text-center">
                    <div id="cover-preview" class="mb-3">
                        <img id="coverImage" src="<?= base_url('assets/Cover_buku/' . $data_edit['cover_buku']); ?>" alt="Cover Buku" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="cover_buku" class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" id="cover_buku" name="cover_buku" accept=".jpg, .jpeg, .png" onchange="previewCover()">
                        </div>

                        <div class="col-md-12">
                            <label for="judul_buku" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?= $data_edit['judul_buku']; ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="pengarang" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $data_edit['pengarang']; ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $data_edit['penerbit']; ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Masukkan keterangan tentang buku"><?= $data_edit['keterangan']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-6">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $data_edit['isbn']; ?>" required>
                    <small class="form-text text-muted">ISBN harus memiliki 10-13 angka</small>
                </div>

                <div class="col-md-6">
                    <label for="tahun" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?= $data_edit['tahun']; ?>" required>
                </div>
            </div>

            <div class="row g-3 mt-4">
            <div class="col-md-4">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="id_kategori" name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row['id_kategori'] ?>" <?= $row['id_kategori'] == $data_edit['id_kategori'] ? 'selected' : ''; ?>><?= $row['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="id_rak" class="form-label">Rak</label>
                    <select class="form-select" id="id_rak" name="id_rak" required>
                        <option value="">-- Pilih Rak --</option>
                        <?php foreach ($rak as $row) : ?>
                            <option value="<?= $row['id_rak'] ?>" <?= $row['id_rak'] == $data_edit['id_rak'] ? 'selected' : ''; ?>><?= $row['nama_rak'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="jumlah_buku" class="form-label">Stok Buku</label>
                    <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku" value="<?= $data_edit['jumlah_buku']; ?>" required>
                </div>
            </div>

            <div class="text mt-4">
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="<?= base_url('admin/master-data-buku'); ?>" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</main>

<script>
    function previewCover() {
        const coverInput = document.getElementById('cover_buku');
        const coverImage = document.getElementById('coverImage');
        
        if (coverInput.files && coverInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                coverImage.src = e.target.result;
            };
            reader.readAsDataURL(coverInput.files[0]);
        }
    }
</script>
