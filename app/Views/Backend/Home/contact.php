<body>

    <div class="pagetitle">
      <h1>Contact</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section contact">

      <div class="row gy-4">

        <div class="col-xl-6">

          <div class="row">
            <div class="col-lg-6">
              <div class="info-box card" data-aos="fade-down">
                <i class="bi bi-geo-alt"></i>
                <h3>Alamat</h3>
                <p>Jl. Margonda No.8, Pondok Cina, Kecamatan Beji<br>Kota Depok, Jawa Barat 1642</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card" data-aos="fade-down">
                <i class="bi bi-telephone"></i>
                <h3>Telpon Kami</h3>
                <p>(021) 78893140</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card" data-aos="fade-up">
                <i class="bi bi-envelope"></i>
                <h3>Email</h3>
                <p>15220290@bsi.ac.id</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card" data-aos="fade-up">
                <i class="bi bi-clock"></i>
                <h3>Jam Buka</h3>
                <p>Senin - Jumat<br>9:00 WIB - 17:00 WIB</p>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-6">
          <div class="card p-4" data-aos="fade-left">
          <form action="send-email.php" method="post" class="php-email-form">
              <div class="row gy-4" data-aos="fade-left">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Email Anda" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Pesan" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Kirim Pesan</button>
                </div>

              </div>
            </form>
          </div>

        </div>

      </div>

    </section>

<style>
  .row > .col-lg-6, .col-xl-6 {
    display: flex;
  }

  .info-box.card, 


  .php-email-form .row {
    width: 100%;
  }

  .card.p-4 {
    padding: 20px; /* Agar konsisten dengan info-box */
  }
</style>


</body>