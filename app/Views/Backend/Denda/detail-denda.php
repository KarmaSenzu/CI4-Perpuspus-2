<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Pengembalian</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('admin/denda'); ?>">Denda</a></li>
        <li class="breadcrumb-item active">Detail Denda</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="card shadow-sm p-4 bg-white rounded mb-4">

    <div class="row">
      <!-- Informasi Anggota -->
      <div class="col-md-6">
        <h5 class="card-title fw-semibold mb-4">Detail Pengembalian</h5>
        <table class="table table-borderless">
          <tr>
            <td><h6>Nama Lengkap</h6></td>
            <td>:</td>
            <td><h6><?= esc($detail_peminjaman['nama_anggota'] ?? 'Data tidak tersedia'); ?></h6></td>
          </tr>
          <tr>
            <td><h6>Email</h6></td>
            <td>:</td>
            <td><h6><?= esc($detail_peminjaman['email'] ?? 'Data tidak tersedia'); ?></h6></td>
          </tr>
          <tr>
            <td><h6>Judul Buku</h6></td>
            <td>:</td>
            <td><h6><?= esc($detail_peminjaman['judul_buku'] ?? 'Data tidak tersedia'); ?></h6></td>
          </tr>
          <tr>
            <td><h6>Jumlah Pinjam</h6></td>
            <td>:</td>
            <td><h6><?= esc($detail_peminjaman['total_pinjam'] ?? 'Data tidak tersedia'); ?></h6></td>
          </tr>
          <tr>
            <td><h6>Tanggal Peminjaman</h6></td>
            <td>:</td>
            <td><h6><?= isset($detail_peminjaman['tgl_pinjam']) ? date('d-m-Y', strtotime($detail_peminjaman['tgl_pinjam'])) : 'Data tidak tersedia'; ?></h6></td>
          </tr>
          <tr>
            <td><h6>Tenggat</h6></td>
            <td>:</td>
            <td><h6><?= isset($detail_peminjaman['tgl_kembali']) ? date('d-m-Y', strtotime($detail_peminjaman['tgl_kembali'])) : 'Data tidak tersedia'; ?></h6></td>
          </tr>
          <tr>
            <td><h6>Tanggal Pengembalian</h6></td>
            <td>:</td>
            <td><h6><?= isset($detail_peminjaman['tgl_pengembalian']) ? date('d-m-Y', strtotime($detail_peminjaman['tgl_pengembalian'])) : 'Data tidak tersedia'; ?></h6></td>
          </tr>
        </table>
      </div>

      <!-- Bayar Denda Section -->
      <div class="col-md-6">
        <h5 class="card-title fw-semibold mb-4">Bayar Denda</h5>
        <table class="table table-borderless mb-4">
          <tr>
            <td><strong>Total Denda</strong></td>
            <td>:</td>
            <td>Rp <?= number_format($denda, 0, ',', '.'); ?></td>
          </tr>
          <tr>
            <td><strong>Dibayar</strong></td>
            <td>:</td>
            <td>Rp <?= number_format($denda_dibayar, 0, ',', '.'); ?></td>
          </tr>
          <tr>
            <td><strong>Sisa Denda</strong></td>
            <td>:</td>
            <td>Rp <?= number_format($denda - $denda_dibayar, 0, ',', '.'); ?></td>
          </tr>
        </table>

        <?php if ($denda - $denda_dibayar > 0): ?>
          <form action="<?= base_url('admin/bayar-denda/' . $detail_peminjaman['id_peminjaman']); ?>" method="post">
            <div class="mb-3">
              <label for="nominal_bayar" class="form-label">Nominal Bayar</label>
              <input type="number" min="1000" max="<?= $denda - $denda_dibayar; ?>" class="form-control" id="nominal_bayar" name="nominal_bayar" placeholder="Minimal Rp1000" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan</button>
          </form>
        <?php else: ?>
          <div class="alert alert-success" role="alert">
            Semua denda telah dibayar. Tidak ada sisa pembayaran.
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="mt-3">
      <a href="<?= base_url('admin/denda'); ?>" class="btn btn-secondary">Kembali</a>
    </div>

  </div>
</main>
