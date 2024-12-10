<main id="main" class="main">

<div class="pagetitle">
  <h1>Denda</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active">Denda</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <h3>Data Denda</h3>
    </div>
    <hr>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Total Denda</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
<?php
$no = 1;
if (!empty($data_denda)) {
    foreach ($data_denda as $denda) {
        $hari_terlambat = $denda['hari_terlambat'];
        $total_denda = $denda['jumlah_denda'];
        $denda_dibayar = $denda['denda_dibayar'];
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($denda['nama_anggota'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <strong><?= htmlspecialchars($denda['judul_buku'], ENT_QUOTES, 'UTF-8'); ?> (<?= $denda['tahun']; ?>)</strong><br>
            <small><?= htmlspecialchars($denda['pengarang'], ENT_QUOTES, 'UTF-8'); ?></small>
        </td>
        <td><?= date('d-m-Y', strtotime($denda['tgl_pengembalian'])); ?></td>
        <td>
    <?php if ($denda['denda_dibayar'] >= $denda['jumlah_denda']): ?>
        <span class="badge bg-success">Lunas</span>
    <?php elseif ($denda['denda_dibayar'] > 0): ?>
        <span class="badge bg-warning text-dark">Belum Lunas</span>
    <?php else: ?>
        <span class="badge bg-danger">Belum Bayar</span>
    <?php endif; ?>
</td>
<td>Rp. <?= number_format($denda['jumlah_denda'], 0, ',', '.'); ?></td>
        <td>
            <a href="<?= base_url('user/detail-denda/' . $denda['id_peminjaman']); ?>" class="btn btn-sm btn-info">Detail</a>
        </td>
    </tr>
<?php
    }
} else {
    echo '<tr><td colspan="7" class="text-center">Tidak ada data denda.</td></tr>';
}
?>
</tbody>
        </table>
    </div>
</div>
</main>
