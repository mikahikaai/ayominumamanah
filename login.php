<?php
include "database/database.php";
$database = new Database;
$db = $database->getConnection();
session_start();

$errorlogin = false;
if (isset($_SESSION['jabatan'])) {
    if ($_SESSION['jabatan'] == "ADMINKEU") {
        echo '<meta http-equiv="refresh" content="0;url=/"/>';
    } else if ($_SESSION['jabatan'] == "HELPER" or $_SESSION['jabatan'] == "DRIVER"){
        echo '<meta http-equiv="refresh" content="0;url=/agung.php"/>';
    }
    die();
}

if (isset($_POST['login'])) {
    $loginsql = "SELECT * FROM karyawan WHERE username=? and password=?";
    $stmt = $db->prepare($loginsql);
    $stmt->bindParam(1, $_POST['username']);
    $md5 = md5($_POST['password']);
    $stmt->bindParam(2, $md5);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['foto'] = $row['foto'];
        if ($_SESSION['jabatan'] == "ADMINKEU") {
            echo '<meta http-equiv="refresh" content="0;url=../"/>';
            die();
        } else if ($_SESSION['jabatan'] == "HELPER" or $_SESSION['jabatan'] == "DRIVER") {
            echo '<meta http-equiv="refresh" content="0;url=../agung.php"/>';
            die();
        }
    } else {
        $errorlogin = true;
    }
}


// var_dump($errorlogin);
// die();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login | PT PKS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../images/logooo cropped resized compressed.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="login/css/style.css">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

</head>

<body class="img js-fullheight" style="background-image: url(login/images/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">PT PANCURAN KAAPIT SENDANG {ALPHA}</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <div style='display: <?= $errorlogin == true ? "block;" : "none;"; ?>'>
                            <div class="alert alert-danger alert-dismissable">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
                                <h5><i class="fas fa-times"></i> Gagal</h5>
                                Username atau password salah
                            </div>
                        </div>
                        <form action="" method="POST" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" name="login">Masuk</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Ingat Saya
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Lupa Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="login/js/jquery.min.js"></script>
    <script src="login/js/popper.js"></script>
    <script src="login/js/bootstrap.min.js"></script>
    <script src="login/js/main.js"></script>

</body>