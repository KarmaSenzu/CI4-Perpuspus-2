<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Perpuspus.my.id</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- logos -->
  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo.png" rel="logo">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">

  <style>
      .section-title {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background: #0066cc;
    margin: 10px auto 0;
  }
    .card-img-top {
      width: 100%;
      height: auto;
      max-height: 200px;
      object-fit: contain;
    }
    .welcome-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: #0056b3;
    margin-bottom: 20px;
    font-family: 'Poppins', sans-serif;
  }

  .welcome-subtitle {
    text-align: center;
    font-size: 1.2rem;
    color: #555;
    font-style: italic;
    margin-bottom: 40px;
    font-family: 'Open Sans', sans-serif;
  }

  .welcome-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 3px;
    background: #ff6f61;
    margin: 10px auto 0;
    border-radius: 5px;
  }
  </style>
</head>
<!-- Navigation Bar -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="home" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Perpuspus</span>
    </a>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#" data-bs-toggle="tooltip" title="Search">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <a class="nav-link nav-icon" href="home" data-bs-toggle="tooltip" title="Home">
        <i class="bi bi-house"></i>
      </a>

      <a class="nav-link nav-icon" href="daftar-buku" data-bs-toggle="tooltip" title="Daftar Buku">
        <i class="bi bi-book"></i>
      </a>

      <a class="nav-link nav-icon" href="contact" data-bs-toggle="tooltip" title="Contact">
        <i class="bi bi-envelope"></i>
      </a>

      <a class="nav-link nav-icon" href="faq" data-bs-toggle="tooltip" title="FAQ">
        <i class="bi bi-question-circle"></i>
      </a>

      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/logo.png" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">Login</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Tamu</h6>
            <span>Silahkan Login</span>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="admin/login-admin">
              <i class="bi bi-person"></i>
              <span>Login Sebagai Admin</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="user/login-user">
              <i class="bi bi-people"></i>
              <span>Login Sebagai User</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>
