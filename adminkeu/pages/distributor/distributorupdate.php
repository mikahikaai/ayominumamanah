<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
    $updatesql = "UPDATE distributor SET nama=?, paket=?, alamat_dropping=?, no_telepon=?, jarak=?, status_keaktifan=?  WHERE id=?";
    $stmt = $db->prepare($updatesql);
    $stmt->bindParam(1, $_POST['nama']);
    $stmt->bindParam(2, $_POST['paket']);
    $stmt->bindParam(3, $_POST['alamat_dropping']);
    $stmt->bindParam(4, $_POST['no_telepon']);
    $stmt->bindParam(5, $_POST['jarak']);
    $stmt->bindParam(6, $_POST['status_keaktifan']);
    $stmt->bindParam(7, $_GET['id']);

    if ($stmt->execute()) {
        $_SESSION['hasil_update'] = true;
        $_SESSION['pesan'] = "Berhasil Mengubah Data";
    } else {
        $_SESSION['hasil_update'] = false;
        $_SESSION['pesan'] = "Gagal Mengubah Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=distributorread"/>';
}

if (isset($_GET['id'])) {
    $selectsql = "SELECT * FROM distributor where id=?";
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
                <h1 class="m-0">Distributor</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=distributorread">Distributor</a></li>
                    <li class="breadcrumb-item active">Ubah Distributor</li>
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
            <h3 class="card-title">Data Ubah Distributor</h3>
            <a href="?page=distributorread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="id_da">ID Distributor</label>
                    <input type="text" name="id_da" class="form-control" value="<?= $row['id_da']; ?>" style="text-transform: uppercase;" readonly required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $row['nama']; ?>" style="text-transform: uppercase;" required>
                </div>
                <div class="form-group">
                    <label for="paket">Paket</label>
                    <select name="paket" class="form-control" required>
                        <option value="">--Pilih Jenis Paket--</option>
                        <?php
                        $options = array('DISTRIBUTOR', 'SUB DISTRIBUTOR', 'BUKAN SUB/DISTRIBUTOR');
                        foreach ($options as $option) {
                            $selected = $row['paket'] == $option ? 'selected' : '';
                            echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat_dropping">Alamat Dropping</label>
                    <input type="text" name="alamat_dropping" class="form-control" value="<?= $row['alamat_dropping']; ?>" style="text-transform: uppercase;" required>
                </div>
                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= $row['no_telepon']; ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jarak">Jarak Dari Pabrik</label>
                            <input type="text" name="jarak" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= $row['jarak']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_keaktifan">Status Keaktifan</label>
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
                        <!-- <div class="form-group">
                            <label for="kateg">Kategori Jarak</label>
                            <input type="text" name="kateg" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="1" value="<?= $row['kateg']; ?>" required>
                        </div> -->
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_order">Minimal Order</label>
                            <input type="text" name="min_order" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= $row['min_order']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ongkir">Ongkos Kirim</label>
                            <input type="text" name="ongkir" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="1" value="<?= $row['ongkir']; ?>" required>
                        </div>
                    </div>
                </div> -->

                <a href="?page=distributorread" class="btn btn-danger btn-sm float-right">
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