<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
    $updatesql = "UPDATE armada SET plat=?, nama_mobil=?, jenis_mobil=?, kecepatan_kosong=?, kecepatan_muatan=?, status_keaktifan=?  where id=?";
    $stmt = $db->prepare($updatesql);
    $stmt->bindParam(1, $_POST['plat']);
    $stmt->bindParam(2, $_POST['nama_mobil']);
    $stmt->bindParam(3, $_POST['jenis_mobil']);
    $stmt->bindParam(4, $_POST['kecepatan_kosong']);
    $stmt->bindParam(5, $_POST['kecepatan_muatan']);
    $stmt->bindParam(6, $_POST['status_keaktifan']);
    $stmt->bindParam(7, $_GET['id']);
    if ($stmt->execute()) {
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Mengubah Data";
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Mengubah Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=armadaread"/>';
}

if (isset($_GET['id'])) {
    $selectsql = "SELECT * FROM armada where id=?";
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
                <h1 class="m-0">Armada</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=armadaread">Armada</a></li>
                    <li class="breadcrumb-item active">Ubah Armada</li>
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
            <h3 class="card-title">Ubah Data Armada</h3>
            <a href="?page=armadaread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
            <div class="form-group">
                    <label for="plat">Plat</label>
                    <input type="text" name="plat" class="form-control" value="<?= $row['plat']?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_mobil">Nama Mobil</label>
                    <input type="text" name="nama_mobil" class="form-control" value="<?= $row['nama_mobil']?>" required>
                </div>
                <div class="form-group">
                    <label for="jenis_mobil">Jenis Mobil</label>
                    <select name="jenis_mobil" class="form-control" required>
                        <option value="">--Pilih Jenis Mobil--</option>
                        <?php
                        $options = array('S', 'M', 'L', 'XL');
                        foreach ($options as $option) {
                            $selected = $row['jenis_mobil'] == $option ? 'selected' : '';
                            echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecepatan_kosong">Kecepatan Kosong</label>
                    <input type="text" name="kecepatan_kosong" class="form-control" value="<?= $row['kecepatan_kosong']?>" required>
                </div>
                <div class="form-group">
                    <label for="kecepatan_muatan">Kecepatan Muatan</label>
                    <input type="text" name="kecepatan_muatan" class="form-control" value="<?= $row['kecepatan_muatan']?>" required>
                </div>
                <div class="form-group">
                    <label for="status_keaktifan">Jenis Mobil</label>
                    <select name="status_keaktifan" class="form-control" required>
                        <option value="">--Pilih Status Keaktifan--</option>
                        <?php
                        $options = array('AKTIF', 'NON AKTIF');
                        foreach ($options as $option) {
                            $selected = $row['status_keaktifan'] == $option ? 'selected' : '';
                            echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <a href="?page=armadaread" class="btn btn-danger btn-sm float-right">
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