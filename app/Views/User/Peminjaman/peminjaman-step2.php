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

    <!-- Data Anggota -->
    <div class="row bg-white mt-3 mb-3 mx-4 rounded border shadow">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">Data Anggota</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <input type="text" id="nama_anggota" class="form-control" value="<?= $dataAnggota['nama_anggota'] ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_tlp" class="form-label">No Telepon</label>
                        <input type="text" id="no_tlp" class="form-control" value="<?= $dataAnggota['no_tlp'] ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" value="<?= $dataAnggota['email'] ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" id="alamat" class="form-control" value="<?= $dataAnggota['alamat'] ?>" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku yang Dipilih -->
    <div class="row bg-white mt-3 mb-3 mx-4 rounded border shadow">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">Form Peminjaman Buku</h5>
                <?php if ($jumlahTemp > 0): ?>
                    <form id="formPeminjaman" action="<?= base_url('user/simpan-transaksi-peminjaman') ?>" method="post">
                        <?php foreach ($dataTemp as $buku): ?>
                            <div class="card mb-3" style="border: 1px solid #ddd;">
                                <div class="row g-0">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <img src="<?= base_url('/assets/Cover_buku/' . $buku['cover_buku']) ?>" alt="<?= $buku['judul_buku'] ?>" class="img-fluid rounded" style="height: 240px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h5 class="card-title fw-semibold mb-2"><?= $buku['judul_buku'] ?> (<?= $buku['tahun'] ?>)</h5>
                                            <div class="w-100 mb-3">
                                                <table>
                                                    <tr>
                                                        <td><h6 class="text-black-50">Pengarang</h6></td>
                                                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                                                        <td><h6 class="text-black-50"><?= $buku['pengarang'] ?></h6></td>
                                                    </tr>
                                                    <tr>
                                                        <td><h6 class="text-black-50">Penerbit</h6></td>
                                                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                                                        <td><h6 class="text-black-50"><?= $buku['penerbit'] ?></h6></td>
                                                    </tr>
                                                    <tr>
                                                        <td><h6 class="text-black-50">Stok</h6></td>
                                                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                                                        <td><h6 class="text-black-50"><?= $buku['jumlah_buku'] ?></h6></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <label for="total_pinjam[<?= $buku['id_buku'] ?>]" class="form-label">Jumlah Pinjam:</label>
                                                    <input type="number" name="total_pinjam[<?= $buku['id_buku'] ?>]" class="form-control" max="<?= $buku['jumlah_buku'] ?>" min="1" value="1" style="width: 100px;">
                                                </div>
                                                <div>
                                                    <label class="form-label">Durasi Peminjaman:</label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" name="durasi_pinjaman[<?= $buku['id_buku'] ?>]" id="durasi_1[<?= $buku['id_buku'] ?>]" value="1">
                                                            <label class="form-check-label" for="durasi_1[<?= $buku['id_buku'] ?>]">1 Hari</label>
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" name="durasi_pinjaman[<?= $buku['id_buku'] ?>]" id="durasi_7[<?= $buku['id_buku'] ?>]" value="7" checked>
                                                            <label class="form-check-label" for="durasi_7[<?= $buku['id_buku'] ?>]">7 Hari</label>
                                                        </div>
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" name="durasi_pinjaman[<?= $buku['id_buku'] ?>]" id="durasi_14[<?= $buku['id_buku'] ?>]" value="14">
                                                            <label class="form-check-label" for="durasi_14[<?= $buku['id_buku'] ?>]">14 Hari</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="durasi_pinjaman[<?= $buku['id_buku'] ?>]" id="durasi_30[<?= $buku['id_buku'] ?>]" value="30">
                                                            <label class="form-check-label" for="durasi_30[<?= $buku['id_buku'] ?>]">30 Hari</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-start mt-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Pinjam Buku</button>
                        </div>
                    </form>
                <?php else: ?>
                    <p class="text-center">Tidak ada buku yang dipilih untuk dipinjam.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pinjam Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin meminjam buku ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    document.querySelector('#confirmationModal .btn-primary').addEventListener('click', function() {
        document.getElementById('formPeminjaman').submit();
    });
</script>
