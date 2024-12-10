<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Perpuspus</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- logos -->
  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo.png" rel="logo">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">
  
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <img src="../../assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Perpuspus</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Selamat Datang</h5>
                    <p class="text-center small">Masukkan Email dan Password Untuk Login</p>
                  </div>

                  <form action="<?= base_url('user/autentikasi-login'); ?>" method="post" class="row g-3 needs-validation" id="loginForm" novalidate>
    <input type="hidden" name="recaptchaToken" id="recaptchaToken">
    
    <div class="col-12">
        <label for="yourEmail" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="yourEmail" required>
        <div class="invalid-feedback">Masukkan email anda!</div>
    </div>

    <div class="col-12">
        <label for="yourPassword" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="yourPassword" required>
        <div class="invalid-feedback">Masukkan password anda!</div>
    </div>

    <!-- reCAPTCHA v2 -->
    <div class="col-12">
        <div class="g-recaptcha" data-sitekey="6LfHt5UqAAAAAEA8IjrAxWyz63eqB-ZCkwU6DPJg"></div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Login</button>
    </div>
    <div class="col-12">
        <p class="small mb-0">Belum menjadi anggota? <a href="/user/registrasi">Ayo Daftar!</a></p>
     </div>   
</form>


                  <!-- Tombol kembali ke beranda -->
                <div class="text-center mt-3">
                  <a href="/home" class="btn btn-light btn-sm">Kembali ke Home</a>
                </div>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../../assets/vendor/quill/quill.js"></script>
  <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "<?php echo session()->getFlashdata('error'); ?>",
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "<?php echo session()->getFlashdata('success'); ?>",
            });
        <?php endif; ?>
    });
</script>

<script>
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();
    
    var recaptchaResponse = grecaptcha.getResponse();

    if (recaptchaResponse.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Silakan verifikasi reCAPTCHA terlebih dahulu!',
        });
        return;
    }

    document.getElementById('recaptchaToken').value = recaptchaResponse;

    document.getElementById('loginForm').submit();
});

</script>

</body>

</html>