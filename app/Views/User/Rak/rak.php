<main id="main" class="main">

  <div class="pagetitle">
    <h1>Rak</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Rak</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
      <h3>Daftar Rak</h3>
    </div>
    <hr>

    <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th data-sortable="true">#</th>
            <th data-sortable="true">Rak</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($data_rak as $rak) {
          ?>
            <tr>
              <td data-sortable="true"><?= $no++; ?></td>
              <td data-sortable="true"><?= $rak['nama_rak']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</main>