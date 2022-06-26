<?php include_once "../partials/cssdatatables.php" ?>

<?php
if (isset($_POST['button_show'])) {
  $_SESSION['tgl_pengajuan_insentif_awal'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_pengajuan_insentif_awal']);
  $_SESSION['tgl_pengajuan_insentif_akhir'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_pengajuan_insentif_akhir'])->modify('+23 Hours')->modify('59 Minutes')->modify('59 Seconds');

  // var_dump($_SESSION['tgl_rekap_awal']);
  // die();

  echo '<meta http-equiv="refresh" content="0;url=?page=pengajuaninsentif"/>';
}
?>

<div class="content-header">
  <div class="container-fluid">
    <h3>Pilih Periode Pengajuan Insentif</h3>
    <form action="" method="POST">
      <div class="row align-items-center">
        <div class="col-md-2">
          <label for="tgl_pengajuan_insentif_awal">Tanggal Awal</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_pengajuan_insentif_awal">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker2' type='text' class='form-control' data-td-target='#datetimepicker2' placeholder="dd/mm/yyyy" name="tgl_pengajuan_insentif_awal" required>
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-md-2">
          <label for="tgl_pengajuan_insentif_akhir">Tanggal Akhir</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_pengajuan_insentif_akhir">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker3' type='text' class='form-control' data-td-target='#datetimepicker3' placeholder="dd/mm/yyyy" name="tgl_pengajuan_insentif_akhir" required>
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