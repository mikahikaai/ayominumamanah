<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
    $updatesql = "UPDATE jabatan SET nama_jabatan=?, gapok_jabatan=?, tunjangan_jabatan=?, uang_makan_perhari=?  where id=?";
    $stmt = $db->prepare($updatesql);
    $stmt->bindParam(1, $_POST['nama']);
    $stmt->bindParam(2, $_POST['gaji']);
    $stmt->bindParam(3, $_POST['tunjangan']);
    $stmt->bindParam(4, $_POST['umakan']);
    $stmt->bindParam(5, $_GET['id']);

    if ($stmt->execute()) {
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Mengubah Data";
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Mengubah Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=jabatanread"/>';
}

if (isset($_GET['id'])) {
    $selectsql = "SELECT * FROM jabatan where id=?";
    $stmt = $db->prepare($selectsql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jabatan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Jabatan</li>
                    <li class="breadcrumb-item">Ubah Jabatan</li>
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
            <h3 class="card-title">Data Ubah Jabatan</h3>
            <a href="?page=lokasijabatan" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama Jabatan</label>
                    <input type="text" name="nama" class="form-control" value="<?= $row['nama_jabatan'] ?>">
                </div>
                <div class="form-group">
                    <label for="gaji">Gaji Pokok</label>
                    <input type="number" name="gaji" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" value="<?= $row['gapok_jabatan'] ?>">
                </div>
                <div class="form-group">
                    <label for="tunjangan">Tunjangan Jabatan</label>
                    <input type="number" name="tunjangan" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" value="<?= $row['tunjangan_jabatan'] ?>">
                </div>
                <div class="form-group">
                    <label for="umakan">Uang Makan Perhari</label>
                    <input type="number" name="umakan" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" value="<?= $row['uang_makan_perhari'] ?>">
                </div>
                <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_edit" class="btn btn-primary btn-sm float-right mr-1">
                    <i class="fa fa-save"></i> Ubah
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /.content -->