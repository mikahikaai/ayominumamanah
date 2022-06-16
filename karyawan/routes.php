<?php

if (isset($_GET['page'])) {
  $page = $_GET['page'];

  switch ($page) {
    case '':

    case 'home':
      file_exists('pages/home.php') ? include 'pages/home.php' : include '../pages/404.php';
      $title = 'Home';
      break;
    case 'pengajuanupah':
      file_exists('pages/pengajuanupah.php') ? include 'pages/pengajuanupah.php' : include '../pages/404.php';
      $title = 'Pengajuan Upah';
      break;
    case 'detailpengajuanupahdistribusi':
      file_exists('pages/detailpengajuanupahdistribusi.php') ? include 'pages/detailpengajuanupahdistribusi.php' : include '../pages/404.php';
      $title = 'Detail Distribusi';
      break;
    case 'rekapupah':
      file_exists('pages/rekapupah.php') ? include 'pages/rekapupah.php' : include '../pages/404.php';
      $title = 'Rekap Upah';
      break;
    case 'rangerekapupah':
      file_exists('pages/rangerekapupah.php') ? include 'pages/rangerekapupah.php' : include '../pages/404.php';
      $title = 'Rekap Upah';
      break;
    case 'detaildistribusi':
      file_exists('pages/detaildistribusi.php') ? include 'pages/detaildistribusi.php' : include '../pages/404.php';
      $title = 'Detail Distribusi';
      break;
    case 'rekapinsentif':
      file_exists('pages/rekapinsentif.php') ? include 'pages/rekapinsentif.php' : include '../pages/404.php';
      $title = 'Rekap Insentif';
      break;
    case 'rangerekapinsentif':
      file_exists('pages/rangerekapinsentif.php') ? include 'pages/rangerekapinsentif.php' : include '../pages/404.php';
      $title = 'Rekap Insentif';
      break;
    case 'detailinsentifdistribusi':
      file_exists('pages/detailinsentifdistribusi.php') ? include 'pages/detailinsentifdistribusi.php' : include '../pages/404.php';
      $title = 'Detail Distribusi';
      break;
    case 'distribusiread':
      file_exists('pages/distribusiread.php') ? include 'pages/distribusiread.php' : include '../pages/404.php';
      $title = 'Distribusi';
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
