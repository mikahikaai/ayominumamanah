<?php  ?>

<?php
include_once "../partials/cssdatatables.php";

$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_show'])) {
  $_SESSION['tgl_rekap_awal'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_rekap_awal']);
  $_SESSION['tgl_rekap_akhir'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_rekap_akhir'])->modify('+23 Hours')->modify('59 Minutes')->modify('59 Seconds');
  $_SESSION['id_karyawan_rekap_upah'] = $_POST['id_karyawan_rekap_upah'];

  // var_dump($_SESSION['tgl_rekap_awal']);
  // die();

  echo '<meta http-equiv="refresh" content="0;url=?page=rekapupah"/>';
}
?>

<div class="content-header">
  <div class="container-fluid">
    <h3>Pilih Periode Rekap Upah</h3>
    <form action="" method="POST">
      <div class="row mb-2 mt-2 align-items-center">
        <div class="col-md-2">
          <label for="nama">Nama Karyawan</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="nama">:</label>
        </div>
        <div class="col-md-2">
          <select name="id_karyawan_rekap_upah" id="nama_karyawan" class="form-control">
            <?php
            $select_karyawan = "SELECT * FROM karyawan WHERE (jabatan = 'DRIVER' OR jabatan = 'HELPER') AND nama != 'HELPER LUAR' ORDER BY nama ASC";
            $stmt_select_karyawan = $db->prepare($select_karyawan);
            $stmt_select_karyawan->execute();
            while ($row_select_karyawan = $stmt_select_karyawan->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <option value="<?= $row_select_karyawan['id']; ?>"><?= $row_select_karyawan['nama']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-md-2">
          <label for="tgl_rekap_awal">Tanggal Awal</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_rekap_awal">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker2' type='text' class='form-control' data-td-target='#datetimepicker2' placeholder="dd/mm/yyyy" name="tgl_rekap_awal" required>
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-md-2">
          <label for="tgl_rekap_akhir">Tanggal Akhir</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_rekap_akhir">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker3' type='text' class='form-control' data-td-target='#datetimepicker3' placeholder="dd/mm/yyyy" name="tgl_rekap_akhir" required>
        </div>
      </div>
      <button type="submit" name="button_show" class="btn btn-success btn-sm mt-3">
        <i class="fa fa-eye"></i> Tampilkan
      </button>
    </form>
  </div>
</div>

<?php
include_once "../partials/scriptdatatables.php";
?>