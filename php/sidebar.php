<?php
include "session.php";
$current = basename($_SERVER['PHP_SELF']);
?>

<!-- sidebar.php -->
<aside id="layout-menu" class="layout-menu menu-vertical menu">
  <div class="app-brand demo">
    <a href="home.php" class="app-brand-link">
      <img src="../assets/img/avatars/logo.jpg" alt="Logo" class="logo-blue" />
      <span class="app-brand-text menu-text fw-bolder ms-2">ScoutTax</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item <?= $current == 'home.php' ? 'active' : '' ?>">
      <a href="home.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pages</span>
    </li>

    <li class="menu-item <?= $current == 'anggota.php' ? 'active' : '' ?>">
      <a href="anggota.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Basic">Anggota</div>
      </a>
    </li>

    <?php if ($role == 'admin'): ?>
      <li class="menu-item <?= $current == 'absensi.php' ? 'active' : '' ?>">
        <a href="absensi.php" class="menu-link">
        <i class='menu-icon tf-icons bx  bx-calendar'></i>
          <div data-i18n="Basic">Absensi</div>
        </a>
      </li>
    <?php endif; ?>

    <li class="menu-item <?= $current == 'rekap.php' ? 'active' : '' ?>">
      <a href="rekap.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Basic">Rekap</div>
      </a>
    </li>

    <li class="menu-item <?= $current == 'denda.php' ? 'active' : '' ?>">
      <a href="denda.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-wallet"></i>
        <div data-i18n="Basic">Denda</div>
      </a>
    </li>
  </ul>
</aside>

<style>
  /* Sidebar Dark Soft Theme */
  #layout-menu {
    width: 250px;
    background-color: #313647;
    /* warna utama sidebar */
    color: #E0E0E0;
    /* teks abu terang */
    font-family: 'Segoe UI', sans-serif;
  }

  /* Brand */
  #layout-menu .app-brand-link {
    display: flex;
    align-items: center;
    padding: 1rem;
  }

  #layout-menu .app-brand-text {
    color: #FFFFFF;
    /* teks brand putih */
    font-weight: bold;
  }

  /* Logo bundar dengan border soft biru */
  .logo-blue {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #64B5F6;
    /* aksen biru muda */
  }

  /* Menu Items */
  #layout-menu .menu-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: #E0E0E0;
    /* teks abu terang */
    transition: all 0.3s ease;
  }

  #layout-menu .menu-link:hover {
    background-color: #3D4255;
    /* hover lebih terang */
    transform: translateX(5px);
  }

  /* Active menu */
  #layout-menu .menu-item.active .menu-link {
    background-color: #3D4255;
    /* active lebih terang dari bg utama */
    border-left: 4px solid #64B5F6;
    /* aksen biru muda */
  }

  /* Menu Icons */
  #layout-menu .menu-icon {
    margin-right: 0.75rem;
    font-size: 1.2rem;
    color: #E0E0E0;
    transition: color 0.3s;
  }

  #layout-menu .menu-link:hover .menu-icon {
    color: #64B5F6;
    /* aksen biru muda */
  }

  /* Menu Sub-items */
  #layout-menu .menu-sub {
    background-color: rgba(255, 255, 255, 0.05);
    /* sedikit lebih terang */
    padding-left: 0;
  }

  #layout-menu .menu-sub .menu-link {
    padding-left: 2.5rem;
    font-size: 0.95rem;
    color: #B0B0C0;
    /* sub-item lebih soft */
  }

  #layout-menu .menu-sub .menu-link:hover {
    background-color: rgba(100, 181, 246, 0.15);
    /* hover biru lembut */
    color: #64B5F6;
  }

  /* Menu Header */
  #layout-menu .menu-header-text {
    color: #A0A0B0;
    /* teks header soft abu */
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    letter-spacing: 1px;
  }

  /* Scroll shadow */
  #layout-menu .menu-inner-shadow {
    box-shadow: inset 0 -4px 6px rgba(0, 0, 0, 0.2);
  }
</style>
