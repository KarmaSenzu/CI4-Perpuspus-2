<main id="main" class="main">

<div class="pagetitle">
  <h1>Pengembalian</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item">Pengembalian</li>
      <li class="breadcrumb-item active">Kembalikan Buku</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

    <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
        <form action="<?= base_url('user/simpan-pengembalian'); ?>" method="post">
            <input type="hidden" id="id_anggota" name="id_anggota" value="<?= session()->get('ses_id'); ?>">
            <div class="mb-3 mt-3">
                <label for="id_peminjaman" class="form-label fw-bold">Pilih Peminjaman yang Akan Dikembalikan:</label>
                <select class="form-select" name="id_peminjaman" id="id_peminjaman" required>
                    <option value="">Pilih Peminjaman</option>
                    <?php foreach ($data_peminjaman as $peminjaman): ?>
                        <option value="<?= $peminjaman['id_peminjaman']; ?>">
                            <?= $peminjaman['nama_anggota'] . ' - ' . $peminjaman['judul_buku']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary fw-bold rounded">Kembalikan</button>
        </form>
    </div>
</div>
