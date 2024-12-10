<main id="main" class="main">
  <div class="pagetitle">
    <h1>Master Data Anggota</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Anggota</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
      <h3>Data Anggota</h3>
      <div>
        <a href="<?= base_url('/admin/input-data-anggota'); ?>">
          <button type="submit" class="btn btn-outline-primary">+ Tambah Anggota</button>
        </a>
        <a href="<?= base_url('/admin/restore-data-anggota'); ?>">
          <button type="submit" class="btn btn-outline-secondary">Restore Data</button>
        </a>
      </div>
    </div>
    <hr>

    <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th data-sortable="true">#</th>
            <th data-sortable="true">Nama Anggota</th>
            <th data-sortable="true">Email</th>
            <th data-sortable="true">Nomor Telepon</th>
            <th data-sortable="true">Jenis Kelamin</th>
            <th data-sortable="true">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($data_anggota as $anggota) {
          ?>
            <tr>
              <td data-sortable="true"><?= $no++; ?></td>
              <td data-sortable="true"><?= $anggota['nama_anggota']; ?></td>
              <td data-sortable="true"><?= $anggota['email']; ?></td>
              <td data-sortable="true"><?= $anggota['no_tlp']; ?></td>
              <td data-sortable="true"><?= ($anggota['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
              <td data-sortable="true">
  <a href="<?= base_url('admin/edit-data-anggota/' . $anggota['id_anggota']); ?>">
    <button type="button" class="btn btn-sm btn-primary">Edit</button>
  </a>
  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $anggota['id_anggota']; ?>" data-name="<?= $anggota['nama_anggota']; ?>">Hapus</button>
</td>

            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Hapus Data Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data anggota "<strong id="anggotaName">"</strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="confirmDeleteBtn">
          <button type="button" class="btn btn-danger">Hapus</button>
        </a>
      </div>
    </div>
  </div>
</div>


</main>

<script type="text/javascript">
  const deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var idDelete = button.getAttribute('data-id');
    var anggotaName = button.getAttribute('data-name');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    document.getElementById('anggotaName').textContent = anggotaName;

    confirmDeleteBtn.href = '<?= base_url('admin/hapus-anggota/'); ?>' + idDelete;
  });
</script>

