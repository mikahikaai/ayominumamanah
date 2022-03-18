<?php
$database = new Database;
$db = $database->getConnection();

$validasi = "SELECT * FROM bagian WHERE nama_bagian = ?";
$stmt = $db->prepare($validasi);
$stmt->bindParam(1, $_POST['nama_bagian']);
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
        $insertsql = "insert into bagian (nama_bagian, karyawan_id, lokasi_id) values (?,?,?)";
        $stmt = $db->prepare($insertsql);
        $stmt->bindParam(1, $_POST['nama']);
        $stmt->bindParam(2, $_POST['karyawan']);
        $stmt->bindParam(3, $_POST['lokasi']);

        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Menyimpan Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Menyimpan Data";
        }
        echo '<meta http-equiv="refresh" content="0;url=?page=bagianread"/>';
    }
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bagian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Bagian</li>
                    <li class="breadcrumb-item">Tambah Bagian</li>
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
            <h3 class="card-title">Data Tambah Bagian</h3>
            <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama Bagian</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="karyawan">Nama Kepala Bagian</label>
                    <select name="karyawan" class="form-control" required>
                        <option value="">--Pilih Kepala Bagian--</option>
                        <?php
                        $selectksql = "SELECT * FROM karyawan";
                        $stmt_k = $db->prepare($selectksql);
                        $stmt_k->execute();

                        while ($row_k = $stmt_k->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_k['id'] . "\">" . $row_k['nama_lengkap'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="lokasi">Lokasi Kantor</label>
                    <select name="lokasi" class="form-control" required>
                        <option value="">--Pilih Lokasi Kantor--</option>
                        <?php
                        $selectlsql = "SELECT * FROM lokasi";
                        $stmt_l = $db->prepare($selectlsql);
                        $stmt_l->execute();

                        while ($row_l = $stmt_l->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_l['id'] . "\">" . $row_l['nama_lokasi'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
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