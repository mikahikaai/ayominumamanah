<?php
$database = new Database;
$db = $database->getConnection();

$select_distro = "SELECT * FROM distributor ORDER BY nama ASC";
$stmt_distro = $db->prepare($select_distro);
$stmt_distro->execute();

$validasi = "SELECT * FROM distribusi WHERE id = ?";
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
                <h1 class="m-0">Distribusi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=distribusiread">Distribusi</a></li>
                    <li class="breadcrumb-item active">Tambah Distribusi</li>
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
            <h3 class="card-title">Data Tambah Distribusi</h3>
            <a href="?page=distribusiread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="distro1">Tujuan 1</label>
                    <select name="distro1" class="form-control" required>
                        <option value="">--Pilih Nama Distributor--</option>
                        <?php
                        $stmt_distro->execute();
                        while ($row_distro = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_distro['id'] . "\">" . $row_distro['id_da'], " - ", $row_distro['nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="cup1">Muatan Cup</label>
                            <input type="text" name="cup1" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a3301">Muatan A330</label>
                            <input type="text" name="a3301" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a5001">Muatan A500</label>
                            <input type="text" name="a5001" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a6001">Muatan A600</label>
                            <input type="text" name="a6001" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="refill1">Muatan Refill</label>
                            <input type="text" name="refill1" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distro2">Tujuan 2</label>
                    <select name="distro2" class="form-control" required>
                        <option value="">--Pilih Nama Distributor--</option>
                        <?php
                        $stmt_distro->execute();
                        while ($row_distro2 = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_distro2['id'] . "\">" . $row_distro2['id_da'], " - ", $row_distro2['nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="cup2">Muatan Cup</label>
                            <input type="text" name="cup2" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a3302">Muatan A330</label>
                            <input type="text" name="a3301" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a5002">Muatan A500</label>
                            <input type="text" name="a5002" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a6002">Muatan A600</label>
                            <input type="text" name="a6002" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="refill2">Muatan Refill</label>
                            <input type="text" name="refill2" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distro3">Tujuan 3</label>
                    <select name="distro3" class="form-control" required>
                        <option value="">--Pilih Nama Distributor--</option>
                        <?php
                        $stmt_distro->execute();
                        while ($row_distro3 = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_distro3['id'] . "\">" . $row_distro3['id_da'], " - ", $row_distro3['nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="cup3">Muatan Cup</label>
                            <input type="text" name="cup3" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a3303">Muatan A330</label>
                            <input type="text" name="a3303" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a5003">Muatan A500</label>
                            <input type="text" name="a5003" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="a6003">Muatan A600</label>
                            <input type="text" name="a6003" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="refill3">Muatan Refill</label>
                            <input type="text" name="refill3" class="form-control" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="paket">Paket</label>
                    <select name="paket" class="form-control" required>
                        <option value="">--Pilih Jenis Paket--</option>
                        <?php
                        $options = array('DISTRIBUTOR', 'SUB DISTRIBUTOR', 'BUKAN SUB/DISTRIBUTOR');
                        foreach ($options as $option) {
                            $selected = $_POST['paket'] == $option ? 'selected' : '';
                            echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat_dropping">Alamat Dropping</label>
                    <input type="text" name="alamat_dropping" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['alamat'] : '' ?>" style="text-transform: uppercase;" required>
                </div>
                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['no_telepon'] : '' ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jarak">Jarak Dari Pabrik</label>
                            <input type="text" name="jarak" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['jarak'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kateg">Kategori Jarak</label>
                            <input type="text" name="kateg" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="1" value="<?= isset($_POST['button_create']) ? $_POST['kateg'] : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_order">Minimal Order</label>
                            <input type="text" name="min_order" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['min_order'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ongkir">Ongkos Kirim</label>
                            <input type="text" name="ongkir" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="1" value="<?= isset($_POST['button_create']) ? $_POST['ongkir'] : '' ?>" required>
                        </div>
                    </div>
                </div>
                <a href="?page=distributorread" class="btn btn-danger btn-sm float-right">
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