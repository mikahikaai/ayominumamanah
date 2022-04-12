<?php
$database = new Database;
$db = $database->getConnection();

$select_distro = "SELECT * FROM distributor WHERE status_keaktifan = 'AKTIF' ORDER BY nama ASC";
$stmt_distro = $db->prepare($select_distro);
// $stmt_distro->execute();

$select_armada = "SELECT * FROM armada WHERE status_keaktifan = 'AKTIF' ORDER BY plat ASC";
$stmt_armada = $db->prepare($select_armada);
// $stmt_armada->execute();

$select_karyawan = "SELECT * FROM karyawan WHERE status_keaktifan = 'AKTIF' ORDER BY nama ASC";
$stmt_karyawan = $db->prepare($select_karyawan);
// $stmt_karyawan->execute();

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

        

        $select_no_perjalanan = "SELECT no_perjalanan FROM distribusi WHERE MONTH(tanggal) = MONTH(NOW()) and YEAR(tanggal) = YEAR(NOW()) ORDER BY no_perjalanan DESC LIMIT 1";
        $stmt_no_perjalanan = $db->prepare($select_no_perjalanan);
        $stmt_no_perjalanan->execute();
        if ($stmt_no_perjalanan->rowCount() == 0) {
            $no_perjalanan = str_pad('1', 4, '0', STR_PAD_LEFT);
        } else {
            while ($row_no_perjalanan = $stmt_no_perjalanan->fetch(PDO::FETCH_ASSOC)) {
                $no_perjalanan = $row_no_perjalanan['no_perjalanan'];
            }
            $no_perjalanan = str_pad(number_format(substr($no_perjalanan, -4)) + 1, 4, '0', STR_PAD_LEFT);
        }
        $no_perjalanan_new = "NJ/" . date('Y/') . date('m/') . $no_perjalanan;
        $insertsql = "INSERT INTO distribusi (no_perjalanan, id_plat, driver, helper_1, helper_2, nama_pel_1, nama_pel_2, nama_pel_3, bongkar, cup1, a3301, a5001, a6001, refill1, cup2, a3302, a5002, a6002, refill2, cup3, a3303, a5003, a6003, refill3,
        jam_berangkat, estimasi_jam_datang) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($insertsql);
        $stmt->bindParam(1, $no_perjalanan_new);
        $stmt->bindParam(2, $_POST['id_plat']);
        $stmt->bindParam(3, $_POST['driver']);
        $stmt->bindParam(4, $_POST['helper_1']);
        $stmt->bindParam(5, $_POST['helper_2']);
        $stmt->bindParam(6, $_POST['nama_pel_1']);
        $stmt->bindParam(7, $_POST['nama_pel_2']);
        $stmt->bindParam(8, $_POST['nama_pel_3']);
        $stmt->bindParam(9, $_POST['bongkar']);
        $stmt->bindParam(10, $_POST['cup1']);
        $stmt->bindParam(11, $_POST['cup2']);
        $stmt->bindParam(12, $_POST['cup3']);
        $stmt->bindParam(13, $_POST['a3301']);
        $stmt->bindParam(14, $_POST['a3302']);
        $stmt->bindParam(15, $_POST['a3303']);
        $stmt->bindParam(16, $_POST['a5001']);
        $stmt->bindParam(17, $_POST['a5002']);
        $stmt->bindParam(18, $_POST['a5003']);
        $stmt->bindParam(19, $_POST['a6001']);
        $stmt->bindParam(20, $_POST['a6002']);
        $stmt->bindParam(21, $_POST['a6003']);
        $stmt->bindParam(22, $_POST['refill1']);
        $stmt->bindParam(23, $_POST['refill2']);
        $stmt->bindParam(25, $_POST['refill3']);
        $stmt->bindParam(26, $_POST['jam_berangkat']);
        $stmt->bindParam(27, $_POST['estimasi_datang']);
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tujuan 1</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pel_1">Distributor</label>
                            <select name="nama_pel_1" class="form-control" required>
                                <option value="">--Pilih Nama Distributor--</option>
                                <?php
                                $stmt_distro->execute();
                                while ($row_distro = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                                    echo "<option value=\"" . $row_distro['id'] . "\">" . $row_distro['nama'], " - ", $row_distro['id_da'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="cup1">Muatan Cup</label>
                                    <input type="text" name="cup1" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a3301">Muatan A330</label>
                                    <input type="text" name="a3301" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a5001">Muatan A500</label>
                                    <input type="text" name="a5001" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a6001">Muatan A600</label>
                                    <input type="text" name="a6001" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="refill1">Muatan Refill</label>
                                    <input type="text" name="refill1" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tujuan 2</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pel_2">Distributor</label>
                            <select name="nama_pel_2" class="form-control">
                                <option value="">--Pilih Nama Distributor--</option>
                                <?php
                                $stmt_distro->execute();
                                while ($row_distro = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                                    echo "<option value=\"" . $row_distro['id'] . "\">" . $row_distro['nama'], " - ", $row_distro['id_da'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="cup2">Muatan Cup</label>
                                    <input type="text" name="cup2" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a3302">Muatan A330</label>
                                    <input type="text" name="a3301" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a5002">Muatan A500</label>
                                    <input type="text" name="a5002" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a6002">Muatan A600</label>
                                    <input type="text" name="a6002" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="refill2">Muatan Refill</label>
                                    <input type="text" name="refill2" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tujuan 3</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pel_3">Distributor</label>
                            <select name="nama_pel_3" class="form-control">
                                <option value="">--Pilih Nama Distributor--</option>
                                <?php
                                $stmt_distro->execute();
                                while ($row_distro = $stmt_distro->fetch(PDO::FETCH_ASSOC)) {

                                    echo "<option value=\"" . $row_distro['id'] . "\">" . $row_distro['nama'], " - ", $row_distro['id_da'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="cup3">Muatan Cup</label>
                                    <input type="text" name="cup3" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a3303">Muatan A330</label>
                                    <input type="text" name="a3303" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a5003">Muatan A500</label>
                                    <input type="text" name="a5003" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="a6003">Muatan A600</label>
                                    <input type="text" name="a6003" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="refill3">Muatan Refill</label>
                                    <input type="text" name="refill3" class="form-control" style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_plat">Armada</label>
                    <select name="id_plat" class="form-control" required>
                        <option value="">--Pilih Armada--</option>
                        <?php
                        $stmt_armada->execute();
                        while ($row_armada = $stmt_armada->fetch(PDO::FETCH_ASSOC)) {

                            echo "<option value=\"" . $row_armada['id'] . "\">" . $row_armada['plat'], " - ", $row_armada['nama_mobil'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tim Pengirim</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="driver">Supir</label>
                                    <select name="driver" class="form-control" required>
                                        <option value="">--Pilih Nama Supir--</option>
                                        <?php
                                        $stmt_karyawan->execute();
                                        while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {

                                            echo "<option value=\"" . $row_karyawan['id'] . "\">" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="helper_1">Helper 1</label>
                                    <select name="helper_1" class="form-control">
                                        <option value="">--Pilih Nama Helper 1--</option>
                                        <?php
                                        $stmt_karyawan->execute();
                                        while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {

                                            echo "<option value=\"" . $row_karyawan['id'] . "\">" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="helper_2">Helper 2</label>
                                    <select name="helper_2" class="form-control">
                                        <option value="">--Pilih Nama Helper 2--</option>
                                        <?php
                                        $stmt_karyawan->execute();
                                        while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {

                                            echo "<option value=\"" . $row_karyawan['id'] . "\">" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jam_berangkat">Jam Keberangkatan</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input id='datetimepicker1' type='text' class='form-control' data-td-target='#datetimepicker1' placeholder="dd/mm/yyyy hh:mm" name="jam_berangkat" require>
                        </div>
                        <div class="col-md d-flex align-items-center">
                            <div class="form-check">
                                <input type="hidden" name="bongkar" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="bongkar">
                                <label class="form-check-label text-bold" for="flexCheckDefault">
                                    Bongkar muatan?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="?page=distribusiread" class="btn btn-danger btn-sm float-right">
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