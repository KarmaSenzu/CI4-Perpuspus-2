<main id="main" class="main">
    <div class="pagetitle">
        <h1>Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Peminjaman</li>
                <li class="breadcrumb-item active">Peminjaman Fase 2</li>
            </ol>
        </nav>
    </div>

    <div class="container my-4">
        <div class="row bg-light rounded border shadow-sm p-4">
            <div class="col-12 col-lg-6">
                <h5 class="card-title fw-semibold mb-4">Pilih Buku</h5>
                <form method="post" action="<?= base_url('admin/peminjaman-step2'); ?>">
                    <div class="mb-2">
                        <label for="search" class="form-label">Cari Judul, Pengarang atau Penerbit buku</label>
                        <input type="text" class="form-control" id="search" name="search" value="<?= $search; ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            <div class="col-1 mb-3"></div>
            <div class="col-12 col-lg-5 d-flex flex-wrap">
                <h5 class="card-title fw-semibold mb-4">Data Anggota</h5>
                <div class="w-100 mb-4">
                    <table>
                        <tr>
                            <td><h6 class="text-black-50"><b>Nama Anggota</b></h6></td>
                            <td style="width:15px" class="text-center"><h6 class="text-black-50"><b>:</b></h6></td>
                            <td><h6 class="text-black-50"><b><?= isset($dataAnggota['nama_anggota']) ? $dataAnggota['nama_anggota'] : 'Data tidak tersedia'; ?></b></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="text-black-50">Email</h6></td>
                            <td class="text-center"><h6 class="text-black-50">:</h6></td>
                            <td><h6 class="text-black-50"><?= isset($dataAnggota['email']) ? $dataAnggota['email'] : 'Data tidak tersedia'; ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="text-black-50">Nomor telepon</h6></td>
                            <td class="text-center"><h6 class="text-black-50">:</h6></td>
                            <td><h6 class="text-black-50"><?= isset($dataAnggota['no_tlp']) ? $dataAnggota['no_tlp'] : 'Data tidak tersedia'; ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="text-black-50">Alamat</h6></td>
                            <td class="text-center"><h6 class="text-black-50">:</h6></td>
                            <td><h6 class="text-black-50"><?= isset($dataAnggota['alamat']) ? $dataAnggota['alamat'] : 'Data tidak tersedia'; ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="text-black-50">Jenis Kelamin</h6></td>
                            <td class="text-center"><h6 class="text-black-50">:</h6></td>
                            <td><h6 class="text-black-50">
                                <?php 
                                if (isset($dataAnggota['jenis_kelamin'])) {
                                    echo $dataAnggota['jenis_kelamin'] == 'L' ? 'Laki-laki' : ($dataAnggota['jenis_kelamin'] == 'P' ? 'Perempuan' : 'Data tidak tersedia');
                                } else {
                                    echo 'Data tidak tersedia'; 
                                }
                                ?>
                            </h6></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <hr>
        <h5 class="card-title fw-semibold mb-4">Buku Dipilih</h5>
        <div class="row">
            <?php if ($jumlahTemp > 0): ?>
                <?php foreach($dataTemp as $data): ?>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card shadow-sm d-flex flex-row align-items-center book-card">
                            <div class="image-container">
                                <img src="/assets/Cover_buku/<?= $data['cover_buku'];?>" alt="<?= $data['judul_buku']; ?>" class="book-cover">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= $data['judul_buku']; ?> (<?= $data['tahun']; ?>)</h5>
                                    <p class="card-text">Jumlah Buku Tersisa: <?= $data['jumlah_buku']; ?></p>
                                </div>
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="<?= base_url('admin/peminjaman-step3'); ?>" class="btn btn-primary me-2">Konfirmasi</a>
                                    <a href="#" class="btn btn-danger delete-btn" data-id="<?= sha1($data['id_buku']); ?>" data-title="<?= $data['judul_buku']; ?>">
                                        <span class="glyphicon glyphicon-trash"></span> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada buku yang dipilih.</p>
            <?php endif; ?>
        </div>

        <form id="bookForm" action="<?= base_url('admin/simpan-temp-pinjam'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id_anggota" value="<?= $idAnggota; ?>">
        </form>

        <hr>
        <div class="table-responsive">
            <?php if (!empty($dataBuku)): ?>
                <h3>Hasil Pencarian Buku</h3>
                <table id="table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th data-sortable="true">#</th>
                            <th data-sortable="true">Cover Buku</th>
                            <th data-sortable="true">Judul Buku</th>
                            <th data-sortable="true">Penerbit</th>
                            <th data-sortable="true">Kategori</th>
                            <th data-sortable="true">Rak</th>
                            <th data-sortable="true">Jumlah Buku</th>
                            <th data-sortable="true">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($dataBuku as $data): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?php if ($data['cover_buku']): ?>
                                        <a href="/assets/Cover_buku/<?php echo $data['cover_buku'];?>" target="_blank">
                                            <img src="/assets/Cover_buku/<?php echo $data['cover_buku'];?>" alt="Cover Buku" class="cover-image">
                                        </a>
                                    <?php else: ?>
                                        Tidak ada cover
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo $data['judul_buku']; ?> (<?php echo $data['tahun']; ?>)</strong><br>
                                    <small><?php echo $data['pengarang']; ?></small>
                                </td>
                                <td><?= $data['penerbit']; ?></td>
                                <td><?= isset($data['nama_kategori']) ? $data['nama_kategori'] : 'Data tidak tersedia'; ?></td>
                                <td><?= isset($data['nama_rak']) ? $data['nama_rak'] : 'Data tidak tersedia'; ?></td>
                                <td><?= $data['jumlah_buku']; ?></td>
                                <td>
                                    <?php if ($data['jumlah_buku'] != "0"): ?>
                                        <a href="<?= base_url('admin/simpan-temp-pinjam') . "/" . sha1($data['id_buku']); ?>">
                                            <button type="button" class="btn btn-primary">Pinjam</button>
                                        </a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-secondary" disabled>Habis</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Tidak ada buku yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Modal for Deletion Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus buku "<strong id="deleteBookTitle"></strong>" dari keranjang?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const bookTitle = this.getAttribute('data-title');
            const bookId = this.getAttribute('data-id');

            document.getElementById('deleteBookTitle').innerText = bookTitle;

            document.getElementById('confirmDeleteBtn').setAttribute('href', '/admin/hapus-temp-pinjam/' + bookId);

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});
</script>

<style>
.cover-image {
    width: 100px;
    height: auto;
    max-width: 100%;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.book-card {
        height: 200px;
        padding: 10px;
    }

    .image-container {
        flex: 0 0 80px;
        max-height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .book-cover {
        height: auto;
        max-height: 180px;
        width: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .card-body {
        flex: 1;
        padding-left: 10px;
    }

</style>