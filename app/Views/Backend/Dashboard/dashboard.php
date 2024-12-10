<body>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="logout">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns (merged content) -->
        <div class="col-12">
          <div class="row">

          <div class="col-xxl-4 col-md-6">
    <div class="card info-card member-card">
        <div class="card-body">
            <h5 class="card-title">Total Anggota <span></span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6><?= $jumlahAnggota; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Member Card -->

            <!-- Total Buku Card -->
            <div class="col-xxl-4 col-md-6">
    <div class="card info-card book-card">
        <div class="card-body">
            <h5 class="card-title">Total Buku <span></span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-book"></i>
                </div>
                <div class="ps-3">
                    <h6><?= $jumlahBuku; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Book Card -->

<div class="col-xxl-4 col-md-6">
<div class="card info-card category-card">
        <div class="card-body">
            <h5 class="card-title">Total Kategori <span></span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-card-list"></i>
                </div>
                <div class="ps-3">
                    <h6><?= $jumlahKategori; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Category Card -->

<!-- Total Rak Card -->
<div class="col-xxl-4 col-md-6">
              <div class="card info-card shelves-card">
                <div class="card-body">
                  <h5 class="card-title">Total Rak <span></span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bookshelf"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?= $jumlahRak; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
</div><!-- End Shelves Card -->

<!-- Total Peminjaman Card -->
<div class="col-xxl-4 col-md-6">
              <div class="card info-card transaction-card">
                <div class="card-body">
                  <h5 class="card-title">Total Peminjaman <span></span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-plus"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?= $jumlahPeminjaman; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
</div><!-- End Peminjaman Card -->

<!-- Total Pengembalian Card -->
<div class="col-xxl-4 col-md-6">
              <div class="card info-card transaction-card">
                <div class="card-body">
                  <h5 class="card-title">Total Pengembalian <span></span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-journal-minus"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?= $jumlahPengembalian; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
</div><!-- End Pengembalian Card -->

<!-- Status Peminjaman with Dropdown Filter -->
<div class="col-12">
  <div class="card recent-sales overflow-auto">

    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item filter-status" href="#" data-status="All">Semua</a></li>
        <li><a class="dropdown-item filter-status" href="#" data-status="Berjalan">Berjalan</a></li>
        <li><a class="dropdown-item filter-status" href="#" data-status="Selesai">Selesai</a></li>
        <li><a class="dropdown-item filter-status" href="#" data-status="Terlambat">Terlambat</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Status Peminjaman</h5>

      <table class="table table-borderless datatable" id="statusTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Anggota</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Balik</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($data_peminjaman as $peminjaman): ?>
            <tr class="status-row" data-status="<?= $peminjaman['status_transaksi']; ?>">
              <td><?= $no++; ?></td>
              <td><?= $peminjaman['nama_anggota']; ?></td>
              <td><?= $peminjaman['judul_buku']; ?></td>
              <td><?= date('d-m-Y', strtotime($peminjaman['tgl_pinjam'])); ?></td>
              <td><?= $peminjaman['tgl_kembali']; ?></td>
              <td>
                <?php if ($peminjaman['status_transaksi'] == 'Berjalan'): ?>
                  <span class="badge bg-primary">Berjalan</span>
                <?php elseif ($peminjaman['status_transaksi'] == 'Selesai'): ?>
                  <span class="badge bg-success">Selesai</span>
                <?php elseif ($peminjaman['status_transaksi'] == 'Terlambat'): ?>
                  <span class="badge bg-danger">Terlambat</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Top Selling -->
<div class="col-12">
  <div class="card top-selling overflow-auto">
    <div class="card-body pb-0">
      <h5 class="card-title">Buku Tersedia <span></span></h5>
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">Cover</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Kategori</th>
            <th scope="col">Rak</th>
            <th scope="col">Jumlah</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data_buku as $data): ?>
        <tr>
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
            <strong><?php echo $data['judul_buku'];?> (<?php echo $data['tahun'];?>)</strong><br>
            <small><?php echo $data['pengarang'];?> </small>
          </td>
          <td><?php echo $data['nama_kategori'];?></td>
          <td><?php echo $data['nama_rak'];?></td>
          <td><?php echo $data['jumlah_buku'];?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
  </div>
</div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->
  <script>
  document.querySelectorAll('.filter-status').forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      const selectedStatus = this.getAttribute('data-status');
      const rows = document.querySelectorAll('.status-row');

      rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        if (selectedStatus === 'All' || rowStatus === selectedStatus) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  });
</script>

</body>
