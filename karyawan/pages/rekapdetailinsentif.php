<?php include_once "../partials/cssdatatables.php" ?>
<?php
$database = new Database;
$db = $database->getConnection();

$tgl_rekap_awal_insentif = $_SESSION['tgl_rekap_insentif_awal']->format('Y-m-d H:i:s');
$tgl_rekap_akhir_insentif = $_SESSION['tgl_rekap_insentif_akhir']->format('Y-m-d H:i:s');

if (isset($_SESSION['id_karyawan_rekap_insentif'])) {
  $selectSql = "SELECT d.*, i.*, p.*, k.*, i.bongkar bongkar2 FROM pengajuan_insentif_borongan p
  INNER JOIN gaji i ON p.id_insentif = i.id
  INNER JOIN distribusi d ON d.id = i.id_distribusi
  INNER JOIN karyawan k ON k.id = i.id_pengirim
  WHERE k.id=? AND (d.jam_berangkat BETWEEN ? AND ?)";
  $stmt = $db->prepare($selectSql);
  $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_upah']);
  $stmt->bindParam(2, $tgl_rekap_awal_insentif);
  $stmt->bindParam(3, $tgl_rekap_akhir_insentif);
  $stmt->execute();
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Detail Rekap Insentif</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item"><a href="?page=rekappengajuanupah">Rekap Insentif</a></li>
          <li class="breadcrumb-item active">Detail Rekap Insentif</li>
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
      <h3 class="card-title font-weight-bold">Data Detail Rekap Insentif<br>Periode : <?= $_SESSION['tgl_rekap_insentif_awal']->format('d-M-Y') . " sd " . $_SESSION['tgl_rekap_insentif_akhir']->format('d-M-Y') ?></h3>
      <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal & Jam Berangkat</th>
            <th>No Perjalanan</th>
            <th>Nama</th>
            <th>Ontime</th>
            <th>Bongkar</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['tanggal'] ?></td>
              <td><a href="?page=detaildistribusi&id=<?= $row['id_distribusi'] ?>"><?= $row['no_perjalanan'] ?></a></td>
              <td><?= $row['nama'] ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['bongkar2'], 0, ',', '.') ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['ontime'], 0, ',', '.') ?></td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">TOTAL</td>
            <td style="text-align: right; font-weight: bold;"></td>
            <td style="text-align: right; font-weight: bold;"></td>
          </tr>
        </tfoot>
      </table>
      <a href="?page=rangerekapinsentif" class="btn btn-sm mt-2 btn-danger float-right mr-1" <i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
<!-- /.content -->
<?php
include_once "../partials/scriptdatatables.php";
?>
<script>
  $(function() {
    $('#mytable').DataTable({
      footerCallback: function(row, data, start, end, display) {
        var api = this.api();

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ? i.replace(/[^0-9]+/g, "") * 1 : typeof i === 'number' ? i : 0;
        };

        // Total over all pages
        nb_cols = api.columns().nodes().length;
        var j = 4;
        while (j < nb_cols && j < 6) {
          total = api
            .column(j)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);
          $(api.column(j).footer()).html('Rp. ' + total.toLocaleString('id-ID'));
          j++
        }
        // Total over this page
        // pageTotal = api
        //   .column(4, {
        //     page: 'current'
        //   })
        //   .data()
        //   .reduce(function(a, b) {
        //     return intVal(a) + intVal(b);
        //   }, 0);

        // Update footer
        // $(api.column(j).footer()).html('Rp. ' + total.toLocaleString('id-ID'));
      }
    });
  });
</script>