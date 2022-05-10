<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 min-vh-100 position-fixed">
  <!-- Brand Logo -->
  <?php
  if (isset($_SESSION['jabatan'])) {
    if ($_SESSION['jabatan'] == "ADMINKEU") {
      $indexurl = "adminkeu" . "/";
    }
  }
  ?>
  <a href="/<?= $indexurl; ?>" class="brand-link">
    <img src="../dist/img/AdminLTELogo.png" alt="AMDK Amanah" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AMDK Amanah</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
        // var_dump(file_exists("../dist/img/" . "NULL"));
        // die();
        // var_dump($_SESSION['foto']);
        // die();
        ?>
        <img src="../dist/img/<?= file_exists("../dist/img/" . ($_SESSION['foto'] == NULL ? 'null' : $_SESSION['foto'])) ? $_SESSION['foto'] : 'avatarm.png'; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" target="_Blank" class="d-block"><?= $_SESSION['nama']; ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="?page=home" class='nav-link' id='home'>
            <i class="nav-icon fas fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-money-bill"></i>
            <p>
              Penggajian
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="?page=penggajianrekap" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Gaji</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Riwayat Gaji</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item" id='master_data'>
          <a href="#" class="nav-link" id='link_master_data'>
            <i class="fas fa-th nav-icon"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            if ($_SESSION['jabatan'] == "ADMINKEU") {
            ?>
              <li class="nav-item">
                <a href="?page=armadaread" class="nav-link" id='armada'><i class="far fa-circle nav-icon"></i>
                  <p>Armada</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=karyawanread" class="nav-link" id='karyawan'><i class="far fa-circle nav-icon"></i>
                  <p>Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=distributorread" class="nav-link" id="distributor"><i class="far fa-circle nav-icon"></i>
                  <p>Distributor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=distribusiread" class="nav-link" id="distribusi"><i class="far fa-circle nav-icon"></i>
                  <p>Distribusi</p>
                </a>
              </li>
            <?php } else if ($_SESSION['jabatan'] == "SPVDISTRIBUSI") {
            ?>
              <li class="nav-item">
                <a href="?page=distribusiread" class="nav-link" id="distribusi"><i class="far fa-circle nav-icon"></i>
                  <p>Distribusi</p>
                </a>
              </li>
            <?php }; ?>
            <!-- <li class="nav-item">
              <a href="?page=armadaread" class="nav-link" id='armada'><i class="far fa-circle nav-icon"></i>
                <p>Armada</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?page=karyawanread" class="nav-link" id='karyawan'><i class="far fa-circle nav-icon"></i>
                <p>Karyawan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?page=distributorread" class="nav-link" id="distributor"><i class="far fa-circle nav-icon"></i>
                <p>Distributor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?page=distribusiread" class="nav-link" id="distribusi"><i class="far fa-circle nav-icon"></i>
                <p>Distribusi</p>
              </a>
            </li> -->
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>