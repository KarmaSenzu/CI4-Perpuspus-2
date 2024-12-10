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
            <a class="nav-link collapsed" href="peminjaman">
                <i class="bi bi-journal-plus"></i>
                <span>Peminjaman</span>
            </a>
        </li><!-- End Borrow Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pengembalian">
                <i class="bi bi-journal-minus"></i>
                <span>Pengembalian</span>
            </a>
        </li><!-- End Return Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="denda-user">
                <i class="bi bi-currency-dollar"></i>
                <span>Denda</span>
            </a>
        </li><!-- End Fine Page Nav -->

        <li class="nav-heading">Daftar</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="profile">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Member Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="buku">
                <i class="bi bi-book"></i>
                <span>Buku</span>
            </a>
        </li><!-- End Book Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="kategori">
                <i class="bi bi-card-list"></i>
                <span>Kategori</span>
            </a>
        </li><!-- End Category Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="rak">
                <i class="bi bi-bookshelf"></i>
                <span>Rak</span>
            </a>
        </li><!-- End Shelf Page Nav -->

    </ul><!-- End Sidebar Nav -->

</aside><!-- End Sidebar -->

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
