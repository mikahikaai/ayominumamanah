<?php include_once "../partials/cssdatatables.php" ?>

<?php
$database = new Database;
$db = $database->getConnection();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Rekap Pengajuan Insentif</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item active">Rekap Pengajuan Insentif</li>
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
      <h3 class="card-title font-weight-bold">Data Rekap Pengajuan Insentif<br>Periode : <?= $_SESSION['tgl_rekap_awal_pengajuan_insentif']->format('d-M-Y') . " sd " . $_SESSION['tgl_rekap_akhir_pengajuan_insentif']->format('d-M-Y') ?></h3>
      <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal Pengajuan</th>
            <th>No. Pengajuan</th>
            <th>Nama Karyawan</th>
            <th>Tanggal Verifikasi</th>
            <th>Nama Verifikator</th>
            <th>Status</th>
            <th>Total Insentif</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tgl_awal = $_SESSION['tgl_rekap_awal_pengajuan_insentif']->format('Y-m-d H:i:s');
          $tgl_akhir = $_SESSION['tgl_rekap_akhir_pengajuan_insentif']->format('Y-m-d H:i:s');
          if ($_SESSION['id_karyawan_rekap_pengajuan_insentif'] == 'all') {
            $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator FROM pengajuan_insentif_borongan p
          INNER JOIN gaji i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE terbayar='2' AND (p.tgl_pengajuan BETWEEN ? AND ?)";
            $stmt = $db->prepare($selectSql);
            $stmt->bindParam(1, $tgl_awal);
            $stmt->bindParam(2, $tgl_akhir);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
              $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator , SUM(i.bongkar+i.ontime) total_insentif FROM pengajuan_insentif_borongan p
          INNER JOIN gaji i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE terbayar='2' AND (p.tgl_pengajuan BETWEEN ? AND ?)
          GROUP BY no_pengajuan ORDER BY tgl_pengajuan ASC, no_pengajuan ASC";
              $stmt = $db->prepare($selectSql);
              $stmt->bindParam(1, $tgl_awal);
              $stmt->bindParam(2, $tgl_akhir);
              $stmt->execute();
            }
          } else {
            $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator FROM pengajuan_insentif_borongan p
          INNER JOIN gaji i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE i.id_pengirim=? AND (p.tgl_pengajuan BETWEEN ? AND ?)";
            $stmt = $db->prepare($selectSql);
            $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_insentif']);
            $stmt->bindParam(2, $tgl_awal);
            $stmt->bindParam(3, $tgl_akhir);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
              $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator , SUM(i.bongkar+i.ontime) total_insentif FROM pengajuan_insentif_borongan p
          INNER JOIN gaji i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE i.id_pengirim=? AND (p.tgl_pengajuan BETWEEN ? AND ?)
          GROUP BY no_pengajuan ORDER BY tgl_pengajuan DESC";
              $stmt = $db->prepare($selectSql);
              $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_insentif']);
              $stmt->bindParam(2, $tgl_awal);
              $stmt->bindParam(3, $tgl_akhir);
              $stmt->execute();
            }
          }
          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['tgl_pengajuan'] ?></td>
              <td><?= $row['no_pengajuan'] ?></td>
              <td><?= $row['nama_pengirim'] ?></td>
              <td><?= $row['tgl_verifikasi'] ?></td>
              <td><?= $row['nama_verifikator'] ?></td>
              <td>
                <?php
                if ($row['terbayar'] == '0') {
                  echo 'Belum';
                } else if ($row['terbayar'] == '1') {
                  echo 'Mengajukan';
                } else {
                  echo 'Terverifikasi';
                }

                ?>
              </td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['total_insentif'], 0, ',', '.') ?></td>
              <td>
                <a href="?page=rekapdetailpengajuaninsentif&no_pengajuan=<?= $row['no_pengajuan']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Lihat</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="7" style="text-align: center; font-weight: bold;">TOTAL</td>
            <td style="text-align: right; font-weight: bold;"></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      <!-- <form action="" method="post">
        <button type="submit" class="btn btn-md btn-success float-right mt-2" name="ajukan">Ajukan</button>
      </form> -->
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
        var j = 7;
        while (j < nb_cols && j < 8) {
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