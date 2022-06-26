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
    case 'pengajuaninsentif':
      file_exists('pages/pengajuaninsentif.php') ? include 'pages/pengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Pengajuan Insentif';
      break;
    case 'rangepengajuaninsentif':
      file_exists('pages/rangepengajuaninsentif.php') ? include 'pages/rangepengajuaninsentif.php' : include '../pages/404.php';
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
    case 'rekapdetailpengajuaninsentif':
      file_exists('pages/rekapdetailpengajuaninsentif.php') ? include 'pages/rekapdetailpengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Insentif';
      break;
    case 'detailpengajuaninsentif':
      file_exists('pages/detailpengajuaninsentif.php') ? include 'pages/detailpengajuaninsentif.php' : include '../pages/404.php';
      $title = 'Pengajuan Insentif';
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
    case 'detailpengajuan':
      file_exists('pages/detailpengajuan.php') ? include 'pages/detailpengajuan.php' : include '../pages/404.php';
      $title = 'Verifikasi Upah';
      break;
    case 'rangerekappengajuanupah':
      file_exists('pages/rangerekappengajuanupah.php') ? include 'pages/rangerekappengajuanupah.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Upah';
      break;
    case 'rekappengajuanupah':
      file_exists('pages/rekappengajuanupah.php') ? include 'pages/rekappengajuanupah.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Upah';
      break;
    case 'rekapdetailpengajuanupah':
      file_exists('pages/rekapdetailpengajuanupah.php') ? include 'pages/rekapdetailpengajuanupah.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Upah';
      break;
    case 'detaildistribusirekappengajuanupah':
      file_exists('pages/detaildistribusirekappengajuanupah.php') ? include 'pages/detaildistribusirekappengajuanupah.php' : include '../pages/404.php';
      $title = 'Rekap Pengajuan Upah';
      break;
      // case 'karyawanupdate':
      //   file_exists('pages/karyawan/karyawanupdate.php') ? include 'pages/karyawan/karyawanupdate.php' : include '../pages/404.php';
      //   $title = 'Karyawan';
      //   break;
      // case 'karyawandelete':
      //   file_exists('pages/karyawan/karyawandelete.php') ? include 'pages/karyawan/karyawandelete.php' : include '../pages/404.php';
      //   $title = 'Karyawan';
      //   break;
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
