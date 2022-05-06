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

if (isset($_POST['button_edit'])) {
  // <hitung jumlah tim pengirim yang berangkat>
  $array_tim_pengirim = array($_POST['driver'] == '' ? null : $_POST['driver'], $_POST['helper_1'] == '' ? null : $_POST['helper_1'], $_POST['helper_2'] == '' ? null : $_POST['helper_2']);
  $jumlah_tim_pengirim = count(array_filter($array_tim_pengirim)) ?? 0;
  // <akhir hitung jumlah tim pengirim yang berangkat>

  // <hitung jumlah distributor yang diantar>
  $array_distributor = array($_POST['nama_pel_1'], $_POST['nama_pel_2'], $_POST['nama_pel_3']);
  $jumlah_distributor = count(array_filter($array_distributor)) ?? 0;
  // <akhir hitung jumlah distributor yang diantar>

  // <hitung lama keberangkatan>
  $jarak_distro = "SELECT * FROM distributor WHERE id=?";
  $stmt_jarak1 = $db->prepare($jarak_distro);
  $stmt_jarak1->bindParam(1, $_POST['nama_pel_1']);
  $stmt_jarak1->execute();
  $row_jarak1 = $stmt_jarak1->fetch(PDO::FETCH_ASSOC);
  $jarak1 = $row_jarak1['jarak'];

  $stmt_jarak2 = $db->prepare($jarak_distro);
  $stmt_jarak2->bindParam(1, $_POST['nama_pel_2']);
  $stmt_jarak2->execute();
  $row_jarak2 = $stmt_jarak2->fetch(PDO::FETCH_ASSOC);
  $jarak2 = $row_jarak2['jarak'] ?? 0;

  $stmt_jarak3 = $db->prepare($jarak_distro);
  $stmt_jarak3->bindParam(1, $_POST['nama_pel_3']);
  $stmt_jarak3->execute();
  $row_jarak3 = $stmt_jarak3->fetch(PDO::FETCH_ASSOC);
  $jarak3 = $row_jarak3['jarak'] ?? 0;

  $kecepatan_q = "SELECT * FROM armada WHERE id=?";
  $stmt_kecepatan = $db->prepare($kecepatan_q);
  $stmt_kecepatan->bindParam(1, $_POST['id_plat']);
  $stmt_kecepatan->execute();
  $row_kecepatan = $stmt_kecepatan->fetch(PDO::FETCH_ASSOC);
  $kecepatan_muatan = $row_kecepatan['kecepatan_muatan'];
  $kecepatan_kosong = $row_kecepatan['kecepatan_kosong'];

  $jarak_max = max($jarak1, $jarak2, $jarak3);

  $lama_keberangkatan = ($jarak_max / $kecepatan_muatan) * 3600;
  // <akhir hitung lama keberangkatan>

  // <hitung lama bongkar>
  $satuan_waktu_bongkar_cup = 30;
  $satuan_waktu_bongkar_330 = 30;
  $satuan_waktu_bongkar_500 = 35;
  $satuan_waktu_bongkar_600 = 40;
  $satuan_waktu_bongkar_refill = 45;

  $cup1 = !empty($_POST['cup1']) ? $_POST['cup1'] : 0;
  $cup2 = !empty($_POST['cup2']) ? $_POST['cup2'] : 0;
  $cup3 = !empty($_POST['cup3']) ? $_POST['cup3'] : 0;
  $a3301 = !empty($_POST['a3301']) ? $_POST['a3301'] : 0;
  $a3302 = !empty($_POST['a3302']) ? $_POST['a3302'] : 0;
  $a3303 = !empty($_POST['a3303']) ? $_POST['a3303'] : 0;
  $a5001 = !empty($_POST['a5001']) ? $_POST['a5001'] : 0;
  $a5002 = !empty($_POST['a5002']) ? $_POST['a5002'] : 0;
  $a5003 = !empty($_POST['a5003']) ? $_POST['a5003'] : 0;
  $a6001 = !empty($_POST['a6001']) ? $_POST['a6001'] : 0;
  $a6002 = !empty($_POST['a6002']) ? $_POST['a6002'] : 0;
  $a6003 = !empty($_POST['a6003']) ? $_POST['a6003'] : 0;
  $refill1 = !empty($_POST['refill1']) ? $_POST['refill1'] : 0;
  $refill2 = !empty($_POST['refill2']) ? $_POST['refill2'] : 0;
  $refill3 = !empty($_POST['refill3']) ? $_POST['refill3'] : 0;

  $jumlah_cup = $cup1 + $cup2 + $cup3;
  $jumlah_330 = $a3301 + $a3302 + $a3303;
  $jumlah_500 = $a5001 + $a5002 + $a5003;
  $jumlah_600 = $a6001 + $a6002 + $a6003;
  $jumlah_refill = $refill1 + $refill2 + $refill3;

  $lama_bongkar = (($jumlah_cup * $satuan_waktu_bongkar_cup) + ($jumlah_330 * $satuan_waktu_bongkar_330) + ($jumlah_500 * $satuan_waktu_bongkar_500) + ($jumlah_600 * $satuan_waktu_bongkar_600) + ($jumlah_refill * $satuan_waktu_bongkar_refill)) / $jumlah_tim_pengirim;
  // <akhir hitung lama bongkar>

  // <hitung lama muat>
  $satuan_waktu_muat_galkos = 20;
  $lama_muat = $jumlah_refill * $satuan_waktu_muat_galkos;
  // <akhir hitung lama bongkar>

  // <hitung lama istirahat>
  $satuan_waktu_istirahat = 1800;
  $lama_istirahat = $jumlah_distributor * $satuan_waktu_istirahat;
  // <akhir hitung lama istirahat>

  // <hitung lama kepulangan>
  $lama_kepulangan = ($jarak_max / $kecepatan_kosong) * 3600;
  // <akhir hitung lama kepulangan>

  // <hitung lama perjalanan>
  if ($_POST['bongkar'] == 1) {
    $lama_perjalanan = ceil($lama_keberangkatan + $lama_bongkar + $lama_muat + $lama_istirahat + $lama_kepulangan);
  } else {
    $lama_perjalanan = ceil($lama_keberangkatan + $lama_istirahat + $lama_kepulangan);
  }

  $jam_berangkat_format = date_create_from_format('d/m/Y H.i.s', $_POST['jam_berangkat']);
  $jam_berangkat = $jam_berangkat_format->format('Y-m-d H:i:s');
  $format_date_interval = "PT" . $lama_perjalanan . "S";
  $estimasi_datang = $jam_berangkat_format->add(new DateInterval($format_date_interval))->format('Y-m-d H:i:s');

  // <akhir hitung lama perjalanan>

  $updatesql = "UPDATE distribusi SET id_plat=?, driver=?, helper_1=?, helper_2=?, nama_pel_1=?, nama_pel_2=?, nama_pel_3=?, bongkar=?, cup1=?, a3301=?, a5001=?, a6001=?, refill1=?, cup2=?, a3302=?, a5002=?, a6002=?, refill2=?, cup3=?, a3303=?, a5003=?, a6003=?, refill3=?, jam_berangkat=?, estimasi_jam_datang=? where id=?";
  $helper_1 = !empty($_POST['helper_1']) ? $_POST['helper_1'] : null;
  $helper_2 = !empty($_POST['helper_2']) ? $_POST['helper_2'] : null;
  $nama_pel_2 = !empty($_POST['nama_pel_2']) ? $_POST['nama_pel_2'] : null;
  $nama_pel_3 = !empty($_POST['nama_pel_3']) ? $_POST['nama_pel_3'] : null;
  $stmt_update = $db->prepare($updatesql);
  $stmt_update->bindParam(1, $_POST['id_plat']);
  $stmt_update->bindParam(2, $_POST['driver']);
  $stmt_update->bindParam(3, $helper_1);
  $stmt_update->bindParam(4, $helper_2);
  $stmt_update->bindParam(5, $_POST['nama_pel_1']);
  $stmt_update->bindParam(6, $nama_pel_2);
  $stmt_update->bindParam(7, $nama_pel_3);
  $stmt_update->bindParam(8, $_POST['bongkar']);
  $stmt_update->bindParam(9, $_POST['cup1']);
  $stmt_update->bindParam(10, $_POST['a3301']);
  $stmt_update->bindParam(11, $_POST['a5001']);
  $stmt_update->bindParam(12, $_POST['a6001']);
  $stmt_update->bindParam(13, $_POST['refill1']);
  $stmt_update->bindParam(14, $_POST['cup2']);
  $stmt_update->bindParam(15, $_POST['a3302']);
  $stmt_update->bindParam(16, $_POST['a5002']);
  $stmt_update->bindParam(17, $_POST['a6002']);
  $stmt_update->bindParam(18, $_POST['refill2']);
  $stmt_update->bindParam(19, $_POST['cup3']);
  $stmt_update->bindParam(20, $_POST['a3303']);
  $stmt_update->bindParam(21, $_POST['a5003']);
  $stmt_update->bindParam(22, $_POST['a6003']);
  $stmt_update->bindParam(23, $_POST['refill3']);
  $stmt_update->bindParam(24, $jam_berangkat);
  $stmt_update->bindParam(25, $estimasi_datang);
  $stmt_update->bindParam(26, $_GET['id']);
  if ($stmt_update->execute()) {
    $_SESSION['hasil_update'] = true;
    $_SESSION['pesan'] = "Berhasil Mengubah Data";
  } else {
    $_SESSION['hasil_update'] = false;
    $_SESSION['pesan'] = "Gagal Mengubah Data";
  }
  for ($i = 0; $i < 3; $i++) {
    $select_id_insentif = "SELECT * FROM insentif WHERE no_perjalanan=? LIMIT $i,1";
    $stmt_select_id_insentif = $db->prepare($select_id_insentif);
    $stmt_select_id_insentif->bindParam(1, $_POST['no_perjalanan']);
    $stmt_select_id_insentif->execute();
    $row_select_id_insentif = $stmt_select_id_insentif->fetch(PDO::FETCH_ASSOC);
    $id_insentif = $row_select_id_insentif['id'];

    $update_insentif = "UPDATE insentif SET ontime=0, bongkar=0, id_pengirim=? WHERE id=?";
    $stmt_update_insentif = $db->prepare($update_insentif);
    $stmt_update_insentif->bindParam(1, $array_tim_pengirim[$i]);
    $stmt_update_insentif->bindParam(2, $id_insentif);
    $stmt_update_insentif->execute();

    $select_id_upah = "SELECT * FROM upah WHERE no_perjalanan=? LIMIT $i,1";
    $stmt_select_id_upah = $db->prepare($select_id_upah);
    $stmt_select_id_upah->bindParam(1, $_POST['no_perjalanan']);
    $stmt_select_id_upah->execute();
    $row_select_id_upah = $stmt_select_id_upah->fetch(PDO::FETCH_ASSOC);
    $id_upah = $row_select_id_upah['id'];

    $update_upah = "UPDATE upah SET upah= 0, id_pengirim=? WHERE id=?";
		$stmt_update_upah = $db->prepare($update_upah);
		$stmt_update_upah->bindParam(1, $array_tim_pengirim[$i]);
		$stmt_update_upah->bindParam(2, $id_upah);
		$stmt_update_upah->execute();
  }


  echo '<meta http-equiv="refresh" content="0;url=?page=distribusiread"/>';
}

if (isset($_GET['id'])) {
  $selectsql = "SELECT * FROM distribusi where id=?";
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
        <h1 class="m-0">Distribusi</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item"><a href="?page=distribusiread">Distribusi</a></li>
          <li class="breadcrumb-item active">Ubah Distribusi</li>
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
      <h3 class="card-title">Data Ubah Distribusi</h3>
      <a href="?page=distribusiread" class="btn btn-danger btn-sm float-right">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
    </div>
    <div class="card-body">
      <form action="" method="post">
        <input type="hidden" name="no_perjalanan" value="<?= $row['no_perjalanan'];?>">
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
                  $selected = $row_distro['id'] == $row['nama_pel_1'] ? 'selected' : '';
                  echo "<option value=\"" . $row_distro['id'] . "\" $selected>" . $row_distro['nama'], " - ", $row_distro['id_da'], " (", $row_distro['jarak'], " km)" . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="cup1">Muatan Cup</label>
                  <input type="number" name="cup1" class="form-control" value="<?= $row['cup1'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a3301">Muatan A330</label>
                  <input type="number" name="a3301" class="form-control" value="<?= $row['a3301'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a5001">Muatan A500</label>
                  <input type="number" name="a5001" class="form-control" value="<?= $row['a5001'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a6001">Muatan A600</label>
                  <input type="number" name="a6001" class="form-control" value="<?= $row['a6001'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="refill1">Muatan Refill</label>
                  <input type="number" name="refill1" class="form-control" value="<?= $row['refill1'] ?>">
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
                  $selected = $row_distro['id'] == $row['nama_pel_2'] ? 'selected' : '';
                  echo "<option value=\"" . $row_distro['id'] . "\" $selected>" . $row_distro['nama'], " - ", $row_distro['id_da'], " (", $row_distro['jarak'], " km)" . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="cup2">Muatan Cup</label>
                  <input type="number" name="cup2" class="form-control" value="<?= $row['cup2'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a3302">Muatan A330</label>
                  <input type="number" name="a3302" class="form-control" value="<?= $row['a3302'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a5002">Muatan A500</label>
                  <input type="number" name="a5002" class="form-control" value="<?= $row['a5002'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a6002">Muatan A600</label>
                  <input type="number" name="a6002" class="form-control" value="<?= $row['a6002'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="refill2">Muatan Refill</label>
                  <input type="number" name="refill2" class="form-control" value="<?= $row['refill2'] ?>">
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
                  $selected = $row_distro['id'] == $row['nama_pel_3'] ? 'selected' : '';
                  echo "<option value=\"" . $row_distro['id'] . "\" $selected>" . $row_distro['nama'], " - ", $row_distro['id_da'], " (", $row_distro['jarak'], " km)" . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <label for="cup3">Muatan Cup</label>
                  <input type="number" name="cup3" class="form-control" value="<?= $row['cup3'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a3303">Muatan A330</label>
                  <input type="number" name="a3303" class="form-control" value="<?= $row['a3303'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a5003">Muatan A500</label>
                  <input type="number" name="a5003" class="form-control" value="<?= $row['a5003'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="a6003">Muatan A600</label>
                  <input type="number" name="a6003" class="form-control" value="<?= $row['a6003'] ?>">
                </div>
              </div>
              <div class="col-md">
                <div class="form-group">
                  <label for="refill3">Muatan Refill</label>
                  <input type="number" name="refill3" class="form-control" value="<?= $row['refill3'] ?>">
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
              $selected = $row_armada['id'] == $row['id_plat'] ? 'selected' : '';
              echo "<option value=\"" . $row_armada['id'] . "\" $selected>" . $row_armada['plat'], " - ", $row_armada['jenis_mobil'] . "</option>";
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
                      $selected = $row_karyawan['id'] == $row['driver'] ? 'selected' : '';
                      echo "<option value=\"" . $row_karyawan['id'] . "\" $selected>" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
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
                      $selected = $row_karyawan['id'] == $row['helper_1'] ? 'selected' : '';
                      echo "<option value=\"" . $row_karyawan['id'] . "\" $selected>" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
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
                      $selected = $row_karyawan['id'] == $row['helper_2'] ? 'selected' : '';
                      echo "<option value=\"" . $row_karyawan['id'] . "\" $selected>" . $row_karyawan['nama'], " - ", $row_karyawan['sim'] . "</option>";
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
              <input id='datetimepicker1' type='text' class='form-control' data-td-target='#datetimepicker1' placeholder="dd/mm/yyyy hh:mm" name="jam_berangkat" require value="<?= $row['jam_berangkat'] ?>" readonly>
            </div>
            <div class="col-md d-flex align-items-center">
              <div class="form-check">
                <input type="hidden" name="bongkar" value="0">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="bongkar" <?= $row['bongkar'] == 1 ? 'checked' : ''; ?>>
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
        <button type="submit" name="button_edit" class="btn btn-success btn-sm float-right mr-1">
          <i class="fa fa-save"></i> Simpan
        </button>
      </form>
    </div>
  </div>
</div>
<!-- /.content -->
<script>
  $("input[type='number']").on("click", function() {
    $(this).select();
  });
</script>