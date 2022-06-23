<?php

if (isset($_GET['page'])) {
  $page = $_GET['page'];

  switch ($page) {
    case '':

    case 'home':
      file_exists('pages/home.php') ? include 'pages/home.php' : include '../pages/404.php';
      $title = 'Home';
      break;
    case 'distributorread':
      file_exists('pages/distributor/distributorread.php') ? include 'pages/distributor/distributorread.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'distributorcreate':
      file_exists('pages/distributor/distributorcreate.php') ? include 'pages/distributor/distributorcreate.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'distributorupdate':
      file_exists('pages/distributor/distributorupdate.php') ? include 'pages/distributor/distributorupdate.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'distributordelete':
      file_exists('pages/distributor/distributordelete.php') ? include 'pages/distributor/distributordelete.php' : include '../pages/404.php';
      $title = 'Distributor';
      break;
    case 'distribusiread':
      file_exists('pages/distribusi/distribusiread.php') ? include 'pages/distribusi/distribusiread.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'distribusicreate':
      file_exists('pages/distribusi/distribusicreate.php') ? include 'pages/distribusi/distribusicreate.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'distribusiupdate':
      file_exists('pages/distribusi/distribusiupdate.php') ? include 'pages/distribusi/distribusiupdate.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'distribusidelete':
      file_exists('pages/distribusi/distribusidelete.php') ? include 'pages/distribusi/distribusidelete.php' : include '../pages/404.php';
      $title = 'Distribusi';
      break;
    case 'armadaread':
      file_exists('pages/armada/armadaread.php') ? include 'pages/armada/armadaread.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'armadacreate':
      file_exists('pages/armada/armadacreate.php') ? include 'pages/armada/armadacreate.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'armadaupdate':
      file_exists('pages/armada/armadaupdate.php') ? include 'pages/armada/armadaupdate.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'armadadelete':
      file_exists('pages/armada/armadadelete.php') ? include 'pages/armada/armadadelete.php' : include '../pages/404.php';
      $title = 'Armada';
      break;
    case 'karyawanread':
      file_exists('pages/karyawan/karyawanread.php') ? include 'pages/karyawan/karyawanread.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'karyawancreate':
      file_exists('pages/karyawan/karyawancreate.php') ? include 'pages/karyawan/karyawancreate.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'karyawanupdate':
      file_exists('pages/karyawan/karyawanupdate.php') ? include 'pages/karyawan/karyawanupdate.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'karyawandelete':
      file_exists('pages/karyawan/karyawandelete.php') ? include 'pages/karyawan/karyawandelete.php' : include '../pages/404.php';
      $title = 'Karyawan';
      break;
    case 'rangepengajuaninsentif':
      file_exists('pages/rangepengajuaninsentif.php') ? include 'pages/rangepengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Pengajuan Insentif';
      break;
    case 'pengajuaninsentif':
      file_exists('pages/pengajuaninsentif.php') ? include 'pages/pengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Pengajuan Insentif';
      break;
    case 'detailpengajuaninsentif':
      file_exists('pages/detailpengajuaninsentif.php') ? include 'pages/detailpengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Pengajuan Insentif';
      break;
    case 'rangerekappengajuaninsentif':
      file_exists('pages/rangerekappengajuaninsentif.php') ? include 'pages/rangerekappengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Insentif';
      break;
    case 'rekappengajuaninsentif':
      file_exists('pages/rekappengajuaninsentif.php') ? include 'pages/rekappengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Insentif';
      break;
    case 'ubahpassword':
      file_exists('../pages/ubahpassword.php') ? include '../pages/ubahpassword.php' : include '../pages/404.php';
      break;
    case 'spvhome':
      file_exists('pages/spvdist/home.php') ? include 'pages/spvdist/home.php' : include '../pages/404.php';
      break;
    case 'spvdistribusiread':
      file_exists('pages/spvdist/distribusi/distribusiread.php') ? include 'pages/spvdist/distribusi/distribusiread.php' : include '../pages/404.php';
      break;
    case 'spvdistribusiupdate':
      file_exists('pages/spvdist/distribusi/distribusiupdate.php') ? include 'pages/spvdist/distribusi/distribusiupdate.php' : include '../pages/404.php';
      break;
    default:
      include '../pages/404.php';
      $title = '404 Halaman Tidak Ditemukan';
  }
} else {
  include 'pages/home.php';
  $title = 'Home';
}
