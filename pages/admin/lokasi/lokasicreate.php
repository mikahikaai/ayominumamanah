<?php
$database = new Database;
$db = $database->getConnection();

$validasi = "SELECT * FROM lokasi WHERE nama_lokasi = ?";
$stmt = $db->prepare($validasi);
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

    if (isset($_POST['button_create'])) {
        $insertsql = "insert into lokasi (nama_lokasi) values ('" . $_POST['nama_lokasi'] . "')";
        $stmt = $db->prepare($insertsql);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Menambah Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Menambah Data";
        }
        echo '<meta http-equiv="refresh" content="0;url=?page=lokasiread"/>';
    }
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
                    <li class="breadcrumb-item">Tambah Lokasi</li>
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
            <h3 class="card-title">Data Tambah Lokasi</h3>
            <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['nama_lokasi'] : ''?>" required>
                </div>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
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