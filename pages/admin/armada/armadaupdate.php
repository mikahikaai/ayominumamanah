<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
    if ($_POST['lokasi_kantor'] == "") {
?>
        <div class="alert alert-danger alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-times"></i>Gagal</h5>
            Lokasi kantor belum dipilih
        </div>
    <?php
    } else if ($_POST['kepala_bagian'] == "") {
    ?>
        <div class="alert alert-danger alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-times"></i>Gagal</h5>
            Kepala bagian belum dipilih
        </div>
<?php
    } else {
        $updatesql = "UPDATE bagian SET nama_bagian=?, karyawan_id=?, lokasi_id=?  where id=?";
        $stmt = $db->prepare($updatesql);
        $stmt->bindParam(1, $_POST['nama']);
        $stmt->bindParam(2, $_POST['kepala_bagian']);
        $stmt->bindParam(3, $_POST['lokasi_kantor']);
        $stmt->bindParam(4, $_GET['id']);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Mengubah Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Mengubah Data";
        }
        echo '<meta http-equiv="refresh" content="0;url=?page=bagianread"/>';
    }
}

if (isset($_GET['id'])) {
    $selectsql = "SELECT * FROM bagian where id=?";
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
                <h1 class="m-0">Bagian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Bagian</li>
                    <li class="breadcrumb-item">Ubah Bagian</li>
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
            <h3 class="card-title">Data Ubah Bagian</h3>
            <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama Bagian</label>
                    <input type="text" name="nama" class="form-control" value="<?= $row['nama_bagian'] ?>">
                </div>
                <div class="form-group">
                    <label for="kepala_bagian">Nama Kepala Bagian</label>
                    <select name="kepala_bagian" class="form-control">
                        <option value="">--Pilih Kepala Bagian--</option>
                        <?php
                        $selectksql = "SELECT * FROM karyawan";
                        $stmt_k = $db->prepare($selectksql);
                        $stmt_k->execute();

                        while ($row_k = $stmt_k->fetch(PDO::FETCH_ASSOC)) {

                            $selected = $row_k['id'] == $row['karyawan_id'] ? "selected" : "";

                            echo "<option value=\"" . $row_k['id'] . "\"" . $selected . ">" . $row_k['nama_lengkap'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="lokasi_kantor">Lokasi Kantor</label>
                    <select name="lokasi_kantor" class="form-control">
                        <option value="">--Pilih Lokasi Kantor--</option>
                        <?php
                        $selectlsql = "SELECT * FROM lokasi";
                        $stmt_l = $db->prepare($selectlsql);
                        $stmt_l->execute();

                        while ($row_l = $stmt_l->fetch(PDO::FETCH_ASSOC)) {

                            $selected = $row_l['id'] == $row['lokasi_id'] ? "selected" : "";

                            echo "<option value=\"" . $row_l['id'] . "\"" . $selected . ">" . $row_l['nama_lokasi'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
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