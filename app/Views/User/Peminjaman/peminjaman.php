<main id="main" class="main">

<div class="pagetitle">
  <h1>Peminjaman</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active">Peminjaman</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <h3>Data Peminjaman</h3>
        <div>
            <!-- Check if there are any ongoing loans -->
            <?php
            $hasOngoingLoan = false;
            foreach ($data_peminjaman as $peminjaman) {
                if ($peminjaman['status_transaksi'] == 'Berjalan' || $peminjaman['status_transaksi'] == 'Terlambat') {
                    $hasOngoingLoan = true;
                    break;
                }
            }
            ?>

            <?php if ($hasOngoingLoan): ?>
                <!-- Button to trigger the modal -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loanModal">
                    + Tambah Peminjaman
                </button>
            <?php else: ?>
                <!-- Link to add new loan if no ongoing loans -->
                <a href="<?= base_url('user/peminjaman-step1'); ?>">
                    <button type="submit" class="btn btn-outline-primary">+ Tambah Peminjaman</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th data-sortable="true">#</th>
                    <th data-sortable="true">Nama Anggota</th>
                    <th data-sortable="true">Judul Buku</th>
                    <th data-sortable="true">Total Pinjam</th>
                    <th data-sortable="true">Tanggal Pinjam</th>
                    <th data-sortable="true">Tenggat</th>
                    <th data-sortable="true">Status</th>
                    <th data-sortable="true">Opsi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
                foreach ($data_peminjaman as $peminjaman) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $peminjaman['nama_anggota']; ?></td>
                    <td>
                        <strong><?= $peminjaman['judul_buku']; ?> (<?= $peminjaman['tahun']; ?>)</strong><br>
                        <small><?= $peminjaman['pengarang']; ?></small>
                    </td>
                    <td><?= $peminjaman['total_pinjam']; ?></td>
                    <td><?= date('d-m-Y', strtotime($peminjaman['tgl_pinjam'])); ?></td>
                    <td><?= date('d-m-Y', strtotime($peminjaman['tgl_kembali'])); ?></td>
                    <td>
                        <?php if ($peminjaman['status_transaksi'] == 'Berjalan'): ?>
                            <span class="badge bg-primary">Berjalan</span>
                        <?php elseif ($peminjaman['status_transaksi'] == 'Selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif ($peminjaman['status_transaksi'] == 'Terlambat'): ?>
                            <span class="badge bg-danger">Terlambat</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('user/detail-peminjaman/' . $peminjaman['id_peminjaman']); ?>" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loanModalLabel">Gagal Meminjam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Anda masih memiliki peminjaman yang sedang berlangsung atau terlambat. Mohon kembalikan buku terlebih dahulu sebelum melakukan peminjaman baru.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
