<main id="main" class="main">
    <div class="pagetitle">
        <h1>Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item">Peminjaman</li>
                <li class="breadcrumb-item active">Peminjaman Fase 1</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row bg-white mt-3 mb-3 ms-4 me-4 rounded border border-1 shadow">
        <form method="post" action="<?= base_url('admin/peminjaman-step2'); ?>" class="p-4">
            <h3 class="page-header">Input Peminjaman</h3>
            <hr>

            <div class="form-group ms-5 mb-3 mt-3">
                <label for="id_anggota" class="form-label">Pilih Anggota:</label>
                <select class="form-control" id="id_anggota" name="id_anggota" required>
                    <option value="" disabled selected>-- Pilih Anggota --</option>
                    <?php foreach ($dataAnggota as $anggota) { ?>
                        <option value="<?= $anggota['id_anggota'] ?>"><?= $anggota['nama_anggota'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group ms-5 mb-3 mt-3">
                <button type="submit" class="btn btn-primary">Lanjut</button>
                <a href="<?= base_url('admin/transaksi-data-peminjaman'); ?>" class="btn btn-danger me-2">Batal</a>
            </div>
        </form>
    </div><!--/.row-->
</main>

<!-- Modal for displaying messages (error or success) -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Info Penting!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Message content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    <?php if (session()->getFlashdata('error')): ?>
        var errorMessage = '<?= session()->getFlashdata('error'); ?>';
        document.getElementById('modalMessage').innerHTML = errorMessage;
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        var successMessage = '<?= session()->getFlashdata('success'); ?>';
        document.getElementById('modalMessage').innerHTML = successMessage;
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    <?php endif; ?>
</script>