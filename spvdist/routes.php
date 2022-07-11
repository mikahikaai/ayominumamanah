<?php

if (isset($_GET['page'])) {
  $page = $_GET['page'];

  switch ($page) {
    case '':

    case 'home':
      file_exists('pages/home.php') ? include 'pages/home.php' : include '../pages/404.php';
      $title = 'Home';
      break;
    case 'distribusiread':
      file_exists('pages/distribusi/distribusiread.php') ? include 'pages/distribusi/distribusiread.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'distribusivalidasi':
      file_exists('pages/distribusi/distribusivalidasi.php') ? include 'pages/distribusi/distribusivalidasi.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'distribusibatalvalidasi':
      file_exists('pages/distribusi/distribusibatalvalidasi.php') ? include 'pages/distribusi/distribusibatalvalidasi.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'armadaread':
      file_exists('pages/armada/armadaread.php') ? include 'pages/armada/armadaread.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'armadadetail':
      file_exists('pages/armada/armadadetail.php') ? include 'pages/armada/armadadetail.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'distributorread':
      file_exists('pages/distributor/distributorread.php') ? include 'pages/distributor/distributorread.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'distributordetail':
      file_exists('pages/distributor/distributordetail.php') ? include 'pages/distributor/distributordetail.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'karyawanread':
      file_exists('pages/karyawan/karyawanread.php') ? include 'pages/karyawan/karyawanread.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'karyawandetail':
      file_exists('pages/karyawan/karyawandetail.php') ? include 'pages/karyawan/karyawandetail.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'detaildistribusi':
      file_exists('pages/detaildistribusi.php') ? include 'pages/detaildistribusi.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'ubahpassword':
      file_exists('../pages/ubahpassword.php') ? include '../pages/ubahpassword.php' : include '../pages/404.php';
      $title = 'Ubah Password';
      break;
    case 'gantifoto':
      file_exists('../pages/gantifoto.php') ? include '../pages/gantifoto.php' : include '../pages/404.php';
      $title = 'Ubah Foto';
      break;
    case 'rangeprestasikaryawan':
      file_exists('pages/prestasi/rangeprestasikaryawan.php') ? include 'pages/prestasi/rangeprestasikaryawan.php' : include '../pages/404.php';
      $title = 'Prestasi';
      break;
    case 'prestasikaryawan':
      file_exists('pages/prestasi/prestasikaryawan.php') ? include 'pages/prestasi/prestasikaryawan.php' : include '../pages/404.php';
      $title = 'Prestasi';
      break;
    case 'gantiprofil':
      file_exists('../pages/gantiprofil.php') ? include '../pages/gantiprofil.php' : include '../pages/404.php';
      $title = 'Ubah profil';
      break;
    default:
      include '../pages/404.php';
      $title = '404 Halaman Tidak Ditemukan';
  }
} else {
  include 'pages/home.php';
  $title = 'Home';
}
