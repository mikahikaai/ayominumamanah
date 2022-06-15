<?php include_once "../partials/cssdatatables.php" ?>

<?php
if (isset($_POST['button_show'])) {
  $_SESSION['tgl_rekap_insentif_awal'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_rekap_insentif_awal']);
  $_SESSION['tgl_rekap_insentif_akhir'] = DateTime::createFromFormat('d/m/Y', $_POST['tgl_rekap_insentif_akhir'])->modify('+23 Hours')->modify('59 Minutes')->modify('59 Seconds');

  // var_dump($_SESSION['tgl_rekap_awal']);
  // die();

  echo '<meta http-equiv="refresh" content="0;url=?page=rekapinsentif"/>';
}
?>

<div class="content-header">
  <div class="container-fluid">
    <h3>Pilih Periode Rekap Insentif</h3>
    <form action="" method="POST">
      <div class="row mb-2 mt-2 align-items-center">
        <div class="col-md-2">
          <label for="nama">Nama Karyawan</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="nama">:</label>
        </div>
        <div class="col-md-2">
          <select name="nama" id="nama_karyawan" class="form-control">
            <option value=""><?= $_SESSION['nama']; ?></option>
          </select>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-md-2">
          <label for="tgl_rekap_insentif_awal">Tanggal Awal</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_rekap_insentif_awal">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker2' type='text' class='form-control' data-td-target='#datetimepicker2' placeholder="dd/mm/yyyy" name="tgl_rekap_insentif_awal" required>
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-md-2">
          <label for="tgl_rekap_insentif_akhir">Tanggal Akhir</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="tgl_rekap_insentif_akhir">:</label>
        </div>
        <div class="col-md-2">
          <input id='datetimepicker3' type='text' class='form-control' data-td-target='#datetimepicker3' placeholder="dd/mm/yyyy" name="tgl_rekap_insentif_akhir" required>
        </div>
      </div>
      <div class="row mb-2 mt-2 align-items-center">
        <div class="col-md-2">
          <label for="terbayar">Status Terbayar</label>
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <label for="terbayar">:</label>
        </div>
        <div class="col-md-2">
          <select name="terbayar" id="insentif_terbayar" class="form-control">
            <option value="0">Belum</option>
            <option value="1">Sudah</option>
          </select>
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