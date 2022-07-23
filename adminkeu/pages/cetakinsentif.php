<?php
include_once "../partials/cssdatatables.php";
?>

<div class="content-header">
  <div class="card col-md-6">
    <div class="card-header">
      <h3 class="card-title font-weight-bold">Tulis Kode Verifikasi</h3>
    </div>
    <form action="report/reportpengajuaninsentifdetail.php" method="get" target="_blank">
      <div class="card-body">
        <div class="row mb-2 mt-2 align-items-center">
          <div class="col-md-2">
            <label for="kode_verif">Kode Verifikasi</label>
          </div>
          <div class="col-md-1 d-flex justify-content-end">
            <label for="kode_verif">:</label>
          </div>
          <div class="col-md-4">
            <input type="text" name="acc_code" id="">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-warning btn-sm">
              <i class="fa fa-print"></i> Cetak
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
include_once "../partials/scriptdatatables.php";
?>