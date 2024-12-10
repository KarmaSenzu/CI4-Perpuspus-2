<body>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns (merged content) -->
        <div class="col-12">
          <div class="row">

            <!-- Display Current Date and Time -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-weight: bold; font-size: 1.25rem; color: #555;">Hari, Tanggal</h5>
                        <h4 id="current-date" style="font-weight: bold; color: #333; font-size: 2rem; margin-top: 10px;"></h4>
                        <h5 id="current-time" style="font-size: 1.5rem; color: #333; margin-top: 5px;"></h5>
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
function updateDateTime() {
    const now = new Date();
    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    const day = days[now.getDay()];
    const date = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    
    const hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");
    
    const currentDate = `${day}, ${date} ${month} ${year}`;
    const currentTime = `${hours}:${minutes}:${seconds} WIB`;

    document.getElementById('current-date').textContent = currentDate;
    document.getElementById('current-time').textContent = currentTime;
}

setInterval(updateDateTime, 1000);
updateDateTime();
</script>

</body>
