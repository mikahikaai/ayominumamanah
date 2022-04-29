<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $findsql = "SELECT * FROM karyawan where id=?";
    $stmt = $db->prepare($findsql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        if (isset($_POST['button_create'])) {
            $insertsql = "INSERT INTO jabatan_karyawan VALUES (null,?,?,?)";
            $stmt = $db->prepare($insertsql);
            $stmt->bindParam(1, $_POST['jabatan_id']);
            $stmt->bindParam(2, $_POST['karyawan_id']);
            $stmt->bindParam(3, $_POST['tanggal_mulai']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
                $_SESSION['pesan'] = 'Data Berhasil Disimpan';
            } else {
                $_SESSION['hasil'] = false;
                $_SESSION['pesan'] = 'Data Gagal Disimpan';
            }
            echo '<meta http-equiv="refresh" content="0;url=?page=karyawanjabatan&id=' . $_POST['karyawan_id'] . '">';
        }
        if (isset($_POST['button_delete'])) {
            $deletesql = "DELETE FROM jabatan_karyawan WHERE id=?";
            $stmt = $db->prepare($deletesql);
            $stmt->bindParam(1, $_POST['bk_id']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
                $_SESSION['pesan'] = 'Data Berhasil Disimpan';
            } else {
                $_SESSION['hasil'] = false;
                $_SESSION['pesan'] = 'Data Gagal Disimpan';
            }
            echo '<meta http-equiv="refresh" content="0;url=?page=karyawanjabatan&id=' . $_POST['karyawan_id'] . '">';
        }
    } else {
        echo '<meta http-equiv="refresh" content="0;url=?page=karyawanread">';
    }
} else {
    echo '<meta http-equiv="refresh" content="0;url=?page=karyawanread">';
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <?php
        if (isset($_SESSION['hasil'])) {
            if ($_SESSION['hasil']) {
        ?>
                <div class="alert alert-success alert-dismissable">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
                    <h5><i class="icon fas fa-check"></i>Sukses</h5>
                    <?= $_SESSION['pesan'] ?>
                </div>

            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissable">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
                    <h5><i class="icon fas fa-times"></i>Terjadi Kesalahan</h5>
                    <?= $_SESSION['pesan'] ?>
                </div>
        <?php }
            unset($_SESSION['hasil']);
            unset($_SESSION['pesan']);
        } ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Karyawan</li>
                    <li class="breadcrumb-item">Riwayat Jabatan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Jabatan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nik">Nomor Induk Karyawan</label>
                        <input type="text" name="nik" class="form-control" value="<?= $row['nik'] ?>" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nohp">Handphone</label>
                        <input type="text" name="nohp" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" maxlength="14" value="<?= $row['handphone'] ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= $row['nama_lengkap'] ?>" disabled>
            </div>
            <form action="" method="post">
                <input type="hidden" name="karyawan_id" value="<?= $_GET['id'] ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" class="form-control">
                                <option value="">--Pilih Jabatan--</option>
                                <?php

                                $selectsql = 'SELECT * FROM jabatan';
                                $stmtb = $db->prepare($selectsql);
                                $stmtb->execute();
                                while ($rowb = $stmtb->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=\"" . $rowb['id'] . "\">" . $rowb['nama_jabatan'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="button_create" class="btn btn-success btn-block float-right mb-3">
                        <i class="fa fa-save"> Simpan</i>
                    </button>
                </div>
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Jabatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectsql = "SELECT BK.*, B.nama_jabatan FROM jabatan_karyawan BK
                            LEFT JOIN jabatan B ON BK.jabatan_id = B.id WHERE BK.karyawan_id = ?
                            ORDER BY BK.tanggal_mulai DESC";
                        $stmt = $db->prepare($selectsql);
                        $stmt->bindParam(1, $_GET['id']);
                        $stmt->execute();

                        $no = 1;
                        while ($rowb = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $rowb['nama_jabatan'] ?></td>
                                <td><?= $rowb['tanggal_mulai'] ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="bk_id" value="<?= $rowb['id'] ?>">
                                        <input type="hidden" name="karyawan_id" value="<?= $_GET['id'] ?>">
                                        <button type="submit" name="button_delete" class="btn btn-danger btn-sm mr-1" onclick="javasript: return confirm('Konfirmasi data akan dihapus?');">
                                            <i class="fa fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->