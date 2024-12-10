<main id="main" class="main">

<div class="pagetitle">
  <h1>Buku</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active">Buku</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
            <h3>Daftar Buku</h3>
        </div>
        <hr>
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th data-sortable="true">#</th>
                    <th data-sortable="true">Cover Buku</th>
                    <th data-sortable="true">Judul Buku</th>
                    <th data-sortable="true">Kategori</th>
                    <th data-sortable="true">Rak</th>
                    <th data-sortable="true">Jumlah Buku</th>
                    <th data-sortable="true">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach ($data_buku as $data) :
                    ?>
                    <tr>
                        <td><?php echo ++$no; ?></td>
                        <td>
                            <?php if ($data['cover_buku']) : ?>
                                <a href="/assets/Cover_buku/<?php echo $data['cover_buku']; ?>" target="_blank">
                                    <img src="/assets/Cover_buku/<?php echo $data['cover_buku']; ?>" alt="Cover Buku" class="cover-image">
                                </a>
                            <?php else : ?>
                                Tidak ada cover
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('user/detail-buku/' . sha1($data['id_buku'])); ?>">
                                <strong><?php echo $data['judul_buku']; ?> (<?php echo $data['tahun']; ?>)</strong>
                            </a><br>
                            <small><?php echo $data['pengarang']; ?> </small>
                        </td>
                        <td><?php echo $data['nama_kategori']; ?></td>
                        <td><?php echo $data['nama_rak']; ?></td>
                        <td><?php echo $data['jumlah_buku']; ?></td>
                        <td>
                            <?php if ($data['jumlah_buku'] > 0) : ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Stok Habis</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .cover-image {
        width: 100px;
        height: auto;
        max-width: 100%;
    }
</style>
