<main id="main" class="main">

  <div class="pagetitle">
    <h1>Kategori</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Kategori</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
      <h3>Daftar Kategori</h3>
    </div>
    <hr>

    <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th data-sortable="true">#</th>
            <th data-sortable="true">Kategori</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($data_kategori as $kategori) {
          ?>
            <tr>
              <td data-sortable="true"><?= $no++; ?></td>
              <td data-sortable="true"><?= $kategori['nama_kategori']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


</main>

<!-- SweetAlert Library (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
  const deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var idDelete = button.getAttribute('data-id');
    var categoryName = button.getAttribute('data-name');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    document.getElementById('categoryName').textContent = categoryName;

    confirmDeleteBtn.href = '<?= base_url('admin/hapus-data-kategori/'); ?>' + idDelete;
  });
</script>


<style>
  .cover-image {
    width: 100px;
    height: auto;
    max-width: 100%;
  }
</style>
