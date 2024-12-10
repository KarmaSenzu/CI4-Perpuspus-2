<main id="main" class="main">
    <div class="pagetitle">
        <h1>Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Peminjaman</li>
                <li class="breadcrumb-item active">Detail Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <?php
        $tgl_kembali = new DateTime($detail_peminjaman['tgl_kembali']);
        $now = new DateTime();
        $diff = $now->diff($tgl_kembali);
        $sisa_hari = (int)$diff->format('%R%a'); 
    ?>

    <div class="card shadow-sm p-4 bg-white rounded mb-4">
        <h3 class="mb-2">Informasi Peminjaman</h3>
        <hr>

        <div class="row">
            <!-- Informasi Anggota -->
            <div class="col-md-6">
                <h5 class="card-title fw-semibold mb-4">Data Anggota</h5>
                <table class="table table-borderless">
                    <tr><td><h6>Nama Anggota</h6></td><td>:</td><td><h6><?= $detail_peminjaman['nama_anggota'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Email</h6></td><td>:</td><td><h6><?= $detail_peminjaman['email'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Nomor Telepon</h6></td><td>:</td><td><h6><?= $detail_peminjaman['no_tlp'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Alamat</h6></td><td>:</td><td><h6><?= $detail_peminjaman['alamat'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                </table>
            </div>

            <!-- Informasi Buku -->
            <div class="col-md-6">
                <h5 class="card-title fw-semibold mb-4">Data Buku</h5>
                <table class="table table-borderless">
                    <tr><td><h6>Judul Buku</h6></td><td>:</td><td><h6><?= $detail_peminjaman['judul_buku'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Pengarang</h6></td><td>:</td><td><h6><?= $detail_peminjaman['pengarang'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Penerbit</h6></td><td>:</td><td><h6><?= $detail_peminjaman['penerbit'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                    <tr><td><h6>Kategori</h6></td><td>:</td><td><h6><?= $detail_peminjaman['nama_kategori'] ?? 'Data tidak tersedia'; ?></h6></td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="row mb-4">
        <!-- Left Column -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Total Pinjam</h5>
                        <p><?= $detail_peminjaman['total_pinjam']; ?></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Status</h5>
                        <p>
                            <?php if ($detail_peminjaman['status_transaksi'] == 'Selesai'): ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php elseif ($sisa_hari < 0): ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Berjalan</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Deadline</h5>
                        <p>
                            <?php
                            if ($sisa_hari > 0) {
                                echo "$sisa_hari Hari lagi";
                            } elseif ($sisa_hari < 0) {
                                echo "Terlambat " . abs($sisa_hari) . " Hari";
                            } else {
                                echo "Hari ini";
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Waktu Peminjaman</h5>
                        <p><?= date('d F Y', strtotime($detail_peminjaman['tgl_pinjam'])); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Waktu Pengembalian</h5>
                        <p><?= date('d F Y', strtotime($detail_peminjaman['tgl_kembali'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Column -->
        <div class="col-md-3 d-flex align-items-stretch">
        <div class="card shadow-sm p-4 bg-white rounded text-center d-flex flex-column justify-content-center align-items-center w-100">
                <h5>QR Code</h5>
                <img src="<?= $namaQR; ?>" alt="QR Code" class="img-fluid mb-2" style="max-width: 150px;">
                <p><small>UID: <?= $detail_peminjaman['id_peminjaman']; ?></small></p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="<?= base_url('admin/transaksi-data-peminjaman'); ?>" class="btn btn-secondary me-2">Kembali</a>
        <?php if ($detail_peminjaman['status_transaksi'] != 'Selesai'): ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                Selesaikan Peminjaman
            </button>
        <?php endif; ?>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Selesaikan Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menyelesaikan peminjaman ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('admin/proses-pengembalian/' . $detail_peminjaman['id_peminjaman']); ?>" class="btn btn-success">Selesaikan</a>
                </div>
            </div>
        </div>
    </div>
</main>
