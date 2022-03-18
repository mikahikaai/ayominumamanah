<?php
$database = new Database;
$db = $database->getConnection();

$validasinik = "SELECT * FROM karyawan WHERE NIK = ?";
$stmt = $db->prepare($validasinik);
$stmt->bindParam(1, $_POST['nik']);
$stmt->execute();

$validasiusername = "SELECT * FROM pengguna WHERE username = ?";
$stmt2 = $db->prepare($validasiusername);
$stmt2->bindParam(1, $_POST['username']);
$stmt2->execute();

if ($stmt->rowCount() > 0) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-times"></i>Gagal</h5>
        NIK sudah terdaftar
    </div>
<?php
} elseif ($stmt2->rowCount() > 0) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-times"></i>Gagal</h5>
        Username sudah terdaftar
    </div>
    <?php } else {

    if (isset($_POST['button_create'])) {
        if ($_POST['password'] != $_POST['password2']) {
    ?>
            <div class="alert alert-danger alert-dismissable">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
                <h5><i class="icon fas fa-times"></i>Gagal</h5>
                Password tidak sama
            </div>
        <?php
        } elseif ($_POST['peran'] == "") {
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
                <h5><i class="icon fas fa-times"></i>Gagal</h5>
                Peran belum dipilih
            </div>
<?php
        } else {
            $md5pass = md5($_POST['password']);
            $insertsql = "INSERT INTO pengguna values (NULL,?,?,?,NULL)";
            $stmt = $db->prepare($insertsql);
            $stmt->bindParam(1, $_POST['username']);
            $stmt->bindParam(2, $md5pass);
            $stmt->bindParam(3, $_POST['peran']);

            if ($stmt->execute()) {
                $lastid = $db->lastInsertId();
                $insertkaryawansql = "INSERT INTO karyawan values (NULL,?,?,?,?,?,?)";
                $stmtk = $db->prepare($insertkaryawansql);
                $stmtk->bindParam(1, $_POST['nik']);
                $stmtk->bindParam(2, $_POST['nama']);
                $stmtk->bindParam(3, $_POST['nohp']);
                $stmtk->bindParam(4, $_POST['email']);
                $stmtk->bindParam(5, $_POST['tglmasuk']);
                $stmtk->bindParam(6, $lastid);
                if ($stmtk->execute()) {
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil Menyimpan Data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal Menyimpan Data";
                }
                echo '<meta http-equiv="refresh" content="0;url=?page=karyawanread"/>';
            }
        }
    }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Karyawan</li>
                    <li class="breadcrumb-item">Tambah Karyawan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Tambah Karyawan</h3>
            <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nik">Nomor Induk Karyawan</label>
                    <input type="text" name="nik" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" maxlength="16" value="<?= isset($_POST['button_create']) ? $_POST['nik'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['nama'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="nohp">Handphone</label>
                    <input type="text" name="nohp" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['nohp'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['email'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="tglmasuk">Tanggal Masuk</label>
                    <input type="date" name="tglmasuk" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['tglmasuk'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['username'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['password'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="password2">Password (Ulangi)</label>
                    <input type="password" name="password2" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['password2'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="peran">Peran</label>
                    <select name="peran" class="form-control" required>
                        <option value="">--Pilih Peran--</option>
                        <?php
                        $options = array('ADMIN', 'USER');
                        foreach ($options as $option) {
                            $selected = $_POST['peran'] == $option ? 'selected' : '';
                            echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right mr-1">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /.content -->