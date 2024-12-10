<main id="main" class="main">
    <div class="pagetitle">
        <h1>Pengembalian</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item">Pengembalian</li>
                <li class="breadcrumb-item active">Detail Pengembalian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <?php
        $tgl_kembali = strtotime($detail_pengembalian['tgl_pengembalian']);
        $today = strtotime(date('Y-m-d'));
        $sisa_hari = ($tgl_kembali - $today) / (60 * 60 * 24);
    ?>

    <!-- Card Container -->
    <div class="card shadow-sm p-4 bg-white rounded">
        <h3 class="mb-2">Informasi Pengembalian</h3>

        <hr>

        <div class="row">
        <!-- Informasi Anggota -->
        <div class="col-md-6">
            <h5 class="card-title fw-semibold mb-4">Data Anggota</h5>
            <div class="w-100 mb-4">
                <table class="table table-borderless">
                    <tr>
                        <td><h6 class="text-black-50"><b>Nama Anggota</b></h6></td>
                        <td style="width:15px" class="text-center"><h6 class="text-black-50"><b>:</b></h6></td>
                        <td><h6 class="text-black-50"><b><?= isset($detail_pengembalian['nama_anggota']) ? $detail_pengembalian['nama_anggota'] : 'Data tidak tersedia'; ?></b></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Email</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['email']) ? $detail_pengembalian['email'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Nomor Telepon</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['no_tlp']) ? $detail_pengembalian['no_tlp'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Alamat</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['alamat']) ? $detail_pengembalian['alamat'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Buku -->
        <div class="col-md-6">
            <h5 class="card-title fw-semibold mb-4">Data Buku</h5>
            <div class="w-100 mb-4">
                <table class="table table-borderless">
                    <tr>
                        <td><h6 class="text-black-50"><b>Judul Buku</b></h6></td>
                        <td style="width:15px" class="text-center"><h6 class="text-black-50"><b>:</b></h6></td>
                        <td><h6 class="text-black-50"><b><?= isset($detail_pengembalian['judul_buku']) ? $detail_pengembalian['judul_buku'] : 'Data tidak tersedia'; ?></b></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Pengarang</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['pengarang']) ? $detail_pengembalian['pengarang'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Penerbit</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['penerbit']) ? $detail_pengembalian['penerbit'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="text-black-50">Rak</h6></td>
                        <td class="text-center"><h6 class="text-black-50">:</h6></td>
                        <td><h6 class="text-black-50"><?= isset($detail_pengembalian['nama_rak']) ? $detail_pengembalian['nama_rak'] : 'Data tidak tersedia'; ?></h6></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Main Grid Layout -->
    <div class="row mb-4">
        <!-- Left Column -->
        <div class="col-md-9">
            <div class="row">
                <!-- Top Row with Jumlah Buku, Status, and Deadline -->
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Total Pinjam</h5>
                        <p><?= $detail_pengembalian['total_pinjam']; ?></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Status</h5>
                        <p>
                            <?php
                                if ($detail_pengembalian['status_transaksi'] == 'Selesai') {
                                    echo '<span class="badge bg-success">Selesai</span>';
                                } else if ($detail_pengembalian['status_transaksi'] == 'Berjalan') {
                                    echo '<span class="badge bg-primary">Berjalan</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">N/A</span>';
                                }
                            ?>
                        </p>
                    </div>
                </div>

<div class="col-md-4">
    <div class="card shadow-sm p-4 bg-white rounded text-center">
        <h5>Denda</h5>
        <p>
            <?php
                if ($denda > 0) {
                    echo "Rp. " . number_format($denda, 0, ',', '.');
                } else {
                    echo "Tidak ada denda";
                }
            ?>
        </p>
    </div>
</div>
</div>


            <!-- Bottom Row with Waktu Peminjaman and Waktu Pengembalian -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Waktu Peminjaman</h5>
                        <p><?= date('d F Y', strtotime($detail_pengembalian['tgl_pinjam'])); ?></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm p-4 bg-white rounded text-center">
                        <h5>Waktu Pengembalian</h5>
                        <p><?= date('d F Y', strtotime($detail_pengembalian['tgl_kembali'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

<!-- Right Column with QR Code -->
<div class="col-md-3 d-flex align-items-stretch">
    <div class="card shadow-sm p-4 bg-white rounded text-center d-flex flex-column justify-content-center align-items-center w-100">
        <h5>QR Code</h5>
        <img src="<?= $namaQR; ?>" alt="QR Code" class="img-fluid mb-2" style="max-width: 150px;">
        <p><small>UID: <?= $detail_pengembalian['id_pengembalian']; ?></small></p>
    </div>
</div>


        <!-- Action Buttons -->
        <div class="d-flex justify-content-end mt-4">
            <a href="<?= base_url('admin/transaksi-data-pengembalian'); ?>" class="btn btn-secondary me-2">Kembali</a>
        </div>
    </div>
</main>
