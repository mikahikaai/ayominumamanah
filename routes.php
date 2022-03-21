<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
        case '':
            
        case 'home':
            file_exists('pages/home.php') ? include 'pages/home.php' : include 'pages/404.php';
            $title = 'Home';
            break;
        case 'distributorread':
            file_exists('pages/admin/distributor/distributorread.php') ? include 'pages/admin/distributor/distributorread.php' : include 'pages/404.php';
            $title = 'Distributor';
            break;
        case 'distributorcreate':
            file_exists('pages/admin/distributor/distributorcreate.php') ? include 'pages/admin/distributor/distributorcreate.php' : include 'pages/404.php';
            $title = 'Distributor';
            break;
        case 'distributorupdate':
            file_exists('pages/admin/distributor/distributorupdate.php') ? include 'pages/admin/distributor/distributorupdate.php' : include 'pages/404.php';
            $title = 'Distributor';
            break;
        case 'distributordelete':
            file_exists('pages/admin/distributor/distributordelete.php') ? include 'pages/admin/distributor/distributordelete.php' : include 'pages/404.php';
            $title = 'Distributor';
            break;
        case 'jabatanread':
            file_exists('pages/admin/jabatan/jabatanread.php') ? include 'pages/admin/jabatan/jabatanread.php' : include 'pages/404.php';
            break;
        case 'jabatancreate':
            file_exists('pages/admin/jabatan/jabatancreate.php') ? include 'pages/admin/jabatan/jabatancreate.php' : include 'pages/404.php';
            break;
        case 'jabatanupdate':
            file_exists('pages/admin/jabatan/jabatanupdate.php') ? include 'pages/admin/jabatan/jabatanupdate.php' : include 'pages/404.php';
            break;
        case 'jabatandelete':
            file_exists('pages/admin/jabatan/jabatandelete.php') ? include 'pages/admin/jabatan/jabatandelete.php' : include 'pages/404.php';
            break;
        case 'armadaread':
            file_exists('pages/admin/armada/armadaread.php') ? include 'pages/admin/armada/armadaread.php' : include 'pages/404.php';
            $title = 'Armada';
            break;
        case 'armadacreate':
            file_exists('pages/admin/armada/armadacreate.php') ? include 'pages/admin/armada/armadacreate.php' : include 'pages/404.php';
            $title = 'Armada';
            break;
        case 'armadaupdate':
            file_exists('pages/admin/armada/armadaupdate.php') ? include 'pages/admin/armada/armadaupdate.php' : include 'pages/404.php';
            $title = 'Armada';
            break;
        case 'armadadelete':
            file_exists('pages/admin/armada/armadadelete.php') ? include 'pages/admin/armada/armadadelete.php' : include 'pages/404.php';
            $title = 'Armada';
            break;
        case 'karyawanread':
            file_exists('pages/admin/karyawan/karyawanread.php') ? include 'pages/admin/karyawan/karyawanread.php' : include 'pages/404.php';
            $title = 'Karyawan';
            break;
        case 'karyawancreate':
            file_exists('pages/admin/karyawan/karyawancreate.php') ? include 'pages/admin/karyawan/karyawancreate.php' : include 'pages/404.php';
            $title = 'Karyawan';
            break;
        case 'karyawanupdate':
            file_exists('pages/admin/karyawan/karyawanupdate.php') ? include 'pages/admin/karyawan/karyawanupdate.php' : include 'pages/404.php';
            $title = 'Karyawan';
            break;
        case 'karyawandelete':
            file_exists('pages/admin/karyawan/karyawandelete.php') ? include 'pages/admin/karyawan/karyawandelete.php' : include 'pages/404.php';
            $title = 'Karyawan';
            break;
        case 'karyawanbagian':
            file_exists('pages/admin/karyawanbagian.php') ? include 'pages/admin/karyawanbagian.php' : include 'pages/404.php';
            break;
        case 'karyawanjabatan':
            file_exists('pages/admin/karyawanjabatan.php') ? include 'pages/admin/karyawanjabatan.php' : include 'pages/404.php';
            break;
        case 'penggajianrekap':
            file_exists('pages/admin/penggajianrekap.php') ? include 'pages/admin/penggajianrekap.php' : include 'pages/404.php';
            break;
        case 'penggajianrekaptahun':
            file_exists('pages/admin/penggajianrekaptahun.php') ? include 'pages/admin/penggajianrekaptahun.php' : include 'pages/404.php';
            break;
        case 'penggajianrekapbulan':
            file_exists('pages/admin/penggajianrekapbulan.php') ? include 'pages/admin/penggajianrekapbulan.php' : include 'pages/404.php';
            break;
        default:
            include 'pages/404.php';
            $title = '404 Halaman Tidak Ditemukan';
    }
} else {
    include 'pages/home.php';
    $title = 'Home';
}
