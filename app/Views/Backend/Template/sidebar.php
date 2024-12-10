<?php if (isset($ses_level) && ($ses_level == "1" || $ses_level == "2")) { ?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Transaksi</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="transaksi-data-peminjaman">
          <i class="bi bi-journal-plus"></i>
          <span>Peminjaman</span>
        </a>
      </li><!-- End Borrow Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="transaksi-data-pengembalian">
          <i class="bi bi-journal-minus"></i>
          <span>Pengembalian</span>
        </a>
      </li><!-- End Return Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="denda">
          <i class="bi bi-currency-dollar"></i>
          <span>Denda</span>
        </a>
      </li><!-- End Fine Page Nav -->

      <li class="nav-heading">Master Data</li>

      <?php if ($ses_level == "1") { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="master-data-admin">
          <i class="bi bi-person"></i>
          <span>Admin</span>
        </a>
      </li><!-- End Admin Page Nav -->
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link collapsed" href="master-data-anggota">
          <i class="bi bi-people"></i>
          <span>Anggota</span>
        </a>
      </li><!-- End Member Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="master-data-buku">
          <i class="bi bi-book"></i>
          <span>Buku</span>
        </a>
      </li><!-- End Book Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="master-data-kategori">
          <i class="bi bi-card-list"></i>
          <span>Kategori</span>
        </a>
      </li><!-- End Category Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="master-data-rak">
          <i class="bi bi-bookshelf"></i>
          <span>Rak</span>
        </a>
      </li><!-- End Shelf Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentUrl = window.location.href;
        var sidebarLinks = document.querySelectorAll('.nav-link');
        sidebarLinks.forEach(function (link) {
            if (link.href === currentUrl) {
                link.classList.add('active');
            }
        });
    });
</script>
<?php } ?>