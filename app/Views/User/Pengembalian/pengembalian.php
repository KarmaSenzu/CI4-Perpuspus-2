<main id="main" class="main">

<div class="pagetitle">
  <h1>Pengembalian</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active">Pengembalian</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
  <table id="table" class="table table-striped table-bordered">
    <div class="fw-bold mb-3 mt-3">
      <h3>Data Pengembalian</h3>
    </div>
    <hr>
    <thead>
      <tr>
        <th data-sortable="true">#</th>
        <th data-sortable="true">Nama Anggota</th>
        <th data-sortable="true">Judul Buku</th>
        <th data-sortable="true">Total Pinjam</th>
        <th data-sortable="true">Tanggal Pinjam</th>
        <th data-sortable="true">Tenggat</th>
        <th data-sortable="true">Tanggal Pengembalian</th>
        <th data-sortable="true">Status</th>
        <th data-sortable="true">Opsi</th>
      </tr>
    </thead>
    <tbody>
    <?php
        $no = 1;
        foreach ($data_pengembalian as $pengembalian) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $pengembalian['nama_anggota']; ?></td>
            <td>
                <strong><?= $pengembalian['judul_buku']; ?> (<?= $pengembalian['tahun']; ?>)</strong><br>
                <small><?= $pengembalian['pengarang']; ?></small>
            </td>
            <td><?= $pengembalian['total_pinjam']; ?></td>
            <td><?= date('d-m-Y', strtotime($pengembalian['tgl_pinjam'])); ?></td>
            <td><?= date('d-m-Y', strtotime($pengembalian['tgl_kembali'])); ?></td>
            <td><?= date('d-m-Y', strtotime($pengembalian['tgl_pengembalian'])); ?></td>
            <td><?php if ($pengembalian['status_transaksi'] == 'Berjalan'): ?>
                        <span class="badge bg-primary">Berjalan</span>
                    <?php elseif ($pengembalian['status_transaksi'] == 'Selesai'): ?>
                        <span class="badge bg-success">Selesai</span>
                    <?php endif; ?>
            <td>
                <a href="<?= base_url('user/detail-pengembalian/' . $pengembalian['id_pengembalian']); ?>" class="btn btn-sm btn-info">Detail</a>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
  </table>
</div>
</div>
