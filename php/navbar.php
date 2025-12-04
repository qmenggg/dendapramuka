<?php
include "session.php";
// Tentukan avatar berdasarkan role
$avatar = "../assets/img/avatars/default.png"; // fallback

if ($role === "admin") {
  $avatar = "../assets/img/avatars/admin.png";
} elseif ($role === "viewer") {
  $avatar = "../assets/img/avatars/viewer.png";
}

?>

<!DOCTYPE html>
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>APLIKASI DENDA PRAMUKA</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/avatars/logo.jpg" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  
<style>
.menu-link{
text-decoration: none !important;}   
.app-brand-link,
.app-brand-text {
    text-decoration: none !important;
}

/* ==========================
   DARK MODE GLOBAL
   ========================== */
body.dark-mode {
  background-color: #1f1f1f !important;
  color: #e4e4e4 !important;
}

/* NAVBAR */
body.dark-mode .navbar,
body.dark-mode .layout-navbar {
  background: #2a2a2a !important;
  border-bottom: 1px solid #3a3a3a !important;
}

/* CARD */
body.dark-mode .card {
  background: #2a2a2a !important;
  color: #e4e4e4 !important;
  border-color: #444 !important;
}

body.dark-mode .card-header {
  background: #333 !important;
  border-bottom: 1px solid #444 !important;
}

body.dark-mode .card-footer {
  background: #2a2a2a !important;
  border-top: 1px solid #444 !important;
}

/* TEXT MUTED */
body.dark-mode .small-muted,
body.dark-mode .text-muted {
  color: #bcbcbc !important;
}

/* LIST GROUP */
body.dark-mode .list-group-item {
  background: #292929 !important;
  border-color: #3a3a3a !important;
  color: #e6e6e6 !important;
}

body.dark-mode .leader-row:hover {
  background: rgba(255, 255, 255, 0.05) !important;
}

/* BUTTON */
body.dark-mode .btn-outline-primary {
  color: #9fc6ff !important;
  border-color: #9fc6ff !important;
}

body.dark-mode .btn-outline-primary:hover {
  background: #0d6efd !important;
  color: white !important;
}

/* TABLE (jika ada) */
body.dark-mode table {
  color: #e4e4e4 !important;
}

body.dark-mode th {
  background: #333 !important;
}

body.dark-mode td {
  background: #2a2a2a !important;
}

/* INPUT */
body.dark-mode input,
body.dark-mode select {
  background: #2c2c2c !important;
  color: #fff !important;
  border-color: #555 !important;
}

/* DROPDOWNS */
body.dark-mode .dropdown-menu {
  background: #333 !important;
  border-color: #444 !important;
}

body.dark-mode .dropdown-item {
  color: #fff !important;
}

body.dark-mode .dropdown-item:hover {
  background: #444 !important;
}

/* CHART BACKGROUND FIX */
body.dark-mode canvas {
  background: transparent !important;
}

/* rep */
body, .card, .navbar, .menu {
    transition: background 0.3s, color 0.3s;
}body.dark-mode table {
    color: #e6e6e6;
}

body.dark-mode th {
    background: #2b2b2b !important;
}

body.dark-mode td {
    background: #1f1f1f !important;
}body.dark-mode .card {
    box-shadow: 0 0 12px rgba(255,255,255,0.06);
}.dark-toggle {
    transition: transform .2s;
}

.dark-toggle:active {
    transform: rotate(180deg);
}body.dark-mode .menu-item.active {
    background: rgba(255,255,255,0.05);
}body.dark-mode .navbar {
    backdrop-filter: blur(8px);
    background: rgba(0,0,0,0.3) !important;
}

/* sles */
/* =========================
   TABEL MODE GELAP
   ========================= */
body.dark-mode table,
body.dark-mode table thead th,
body.dark-mode table tbody td {
    color: #ffffff !important;        /* Teks putih */
}

/* Border table biar terlihat */
body.dark-mode table thead th,
body.dark-mode table tbody td {
    border-color: #555 !important;    /* Abu tua */
}

/* Background baris tabel */
body.dark-mode table tbody tr {
    background-color: #2b2b2b !important; /* Abu gelap */
}

body.dark-mode table thead {
    background-color: #333 !important; /* Header gelap */
}

/* Hover biar cakep */
body.dark-mode table tbody tr:hover {
    background-color: #3a3a3a !important;
}

/* rep tutup */

</style>


    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
<?php
include "sidebar.php";
?>
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="d-flex w-100 justify-content-between align-items-center">
    <!-- Toggle menu mobile -->
    <div class="layout-menu-toggle navbar-nav align-items-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="#">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <!-- Navbar Right -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- User Dropdown -->
          <li class="dropdown-item">
          <button id="toggleDark" class="btn btn-sm btn-outline-secondary">
          <i id="iconTheme" class="bx bx-moon"></i>
          </button>
          </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?= $avatar ?>" class="rounded-circle" width="40" alt="User Avatar">
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex align-items-center">
                <img src="<?= $avatar ?>" class="rounded-circle me-3" width="40">
                <div>
                  <span class="fw-semibold d-block"><?= htmlspecialchars($username) ?></span>
                  <small class="text-muted"><?= htmlspecialchars($role) ?></small>
                </div>
              </div>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="logout.php">
              <i class="bx bx-power-off me-2"></i> Log Out
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<script>
  const body = document.body;
  const toggleBtn = document.getElementById("toggleDark");
  const icon = document.getElementById("iconTheme");

  // Load dari localStorage
  if (localStorage.getItem("darkMode") === "enabled") {
    body.classList.add("dark-mode");
    icon.classList.replace("bx-moon", "bx-sun");
  }

  toggleBtn.addEventListener("click", () => {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
      localStorage.setItem("darkMode", "enabled");
      icon.classList.replace("bx-moon", "bx-sun");
    } else {
      localStorage.setItem("darkMode", "disabled");
      icon.classList.replace("bx-sun", "bx-moon");
    }
  });

</script>




        <!-- /Navbar -->



        <!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="../assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- data tables anggota-->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
  $(document).ready(function () {
    $('#example').DataTable();
  });


</script>

<script>
  $(document).ready(function () {
    $('#example').DataTable({
      destroy: true,
      paging: false,
      searching: true,
      info: false
    });
  });
</script>





<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>


<!-- Main JS -->
<script src="../assets/js/main.js"></script>

<!-- Page JS -->
<script src="../assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>