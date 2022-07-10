<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-gear"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item">Pengaturan Pengguna</span>
        <a href="?page=gantifoto" class="dropdown-item">
          <i class="fas fa-circle-user mr-2"></i> Ganti Foto
        </a>
        <a href="?page=ubahinformasi" class="dropdown-item">
        <i class="fa-solid fa-user-pen mr-2"></i>Ubah Data Diri
        </a>
        <a href="?page=ubahpassword" class="dropdown-item">
          <i class="fas fa-key mr-2"></i> Ubah Password
        </a>
        <a href="/logout.php" class="dropdown-item" onClick="javascript: return confirm('Konfirmasi akan logout?');">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>