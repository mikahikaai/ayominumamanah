<?php
$database = new Database;
$db = $database->getConnection();

$validasi = "SELECT * FROM distributor WHERE id_da = ?";
$stmt = $db->prepare($validasi);
$stmt->bindParam(1, $_POST['id_da']);
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
        $insertsql = "insert into distributor (id_da, nama, paket, alamat_dropping, no_telepon, jarak) values (?,?,?,?,?,?)";
        $stmt = $db->prepare($insertsql);
        $id_da = strtoupper($_POST['id_da']);
        $nama_distributor = strtoupper($_POST['nama']);
        $alamat_dropping_distributor = strtoupper($_POST['alamat_dropping']);
        $stmt->bindParam(1, $id_da);
        $stmt->bindParam(2, $nama_distributor);
        $stmt->bindParam(3, $_POST['paket']);
        $stmt->bindParam(4, $alamat_dropping_distributor);
        $stmt->bindParam(5, $_POST['no_telepon']);
        $stmt->bindParam(6, $_POST['jarak']);
        if ($stmt->execute()) {
            $_SESSION['hasil_create'] = true;
            $_SESSION['pesan'] = "Berhasil Menyimpan Data";
        } else {
            $_SESSION['hasil_create'] = false;
            $_SESSION['pesan'] = "Gagal Menyimpan Data";
        }
        echo '<meta http-equiv="refresh" content="0;url=?page=distributorread"/>';
    }
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
                    <li class="breadcrumb-item">Tambah Distributor</li>
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
            <h3 class="card-title">Data Tambah Distributor</h3>
            <a href="?page=distributorread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="id_da">ID Distributor</label>
                    <input type="text" name="id_da" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['id_da'] : '' ?>" style="text-transform: uppercase;" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= isset($_POST['button_create']) ? $_POST['nama'] : '' ?>" style="text-transform: uppercase;" required>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jarak">Jarak Dari Pabrik</label>
                            <input type="text" name="jarak" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['jarak'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= isset($_POST['button_create']) ? $_POST['no_telepon'] : '' ?>" required>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="kateg">Kategori Jarak</label>
                            <input type="text" name="kateg" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="1" value="<?= isset($_POST['button_create']) ? $_POST['kateg'] : '' ?>" required>
                        </div>
                    </div> -->
                </div>
                <!-- <div class="row">
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
                </div> -->
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
</div>
<!-- /.content -->