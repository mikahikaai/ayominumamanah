<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
    $ceksql = "SELECT * FROM lokasi where nama_lokasi=?";
    $stmt = $db->prepare($ceksql);
    $stmt->bindParam(1, $_POST['nama_lokasi']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-times"></i>Gagal</h5>
            Data sudah ada di database
        </div>
<?php
    } else {
        $updatesql = "UPDATE lokasi SET nama_lokasi=? where id=?";
        $stmt = $db->prepare($updatesql);
        $stmt->bindParam(1, $_POST['nama_lokasi']);
        $stmt->bindParam(2, $_GET['id']);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Menambah Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Menambah Data";
        }
        echo '<meta http-equiv="refresh" content="1;url=?page=lokasiread"/>';
    }
}

if (isset($_GET['id'])) {
    $selectsql = "SELECT * FROM lokasi where id=?";
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
                <h1 class="m-0">Lokasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Lokasi</li>
                    <li class="breadcrumb-item">Ubah Lokasi</li>
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
            <h3 class="card-title">Data Ubah Lokasi</h3>
            <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" class="form-control" value="<?= $row['nama_lokasi']; ?>">
                </div>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_edit" class="btn btn-success btn-sm float-right mr-1">
                    <i class="fa fa-save"></i> Ubah
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /.content -->