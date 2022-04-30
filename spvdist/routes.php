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
        default:
            include '../pages/404.php';
            $title = '404 Halaman Tidak Ditemukan';
    }
} else {
    include 'pages/home.php';
    $title = 'Home';
}
