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
      <h3 class="card-title">Data Insentif Sudah Terbayar</h3>
      <!-- <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a> -->
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal Pengajuan</th>
            <th>No. Pengajuan</th>
            <th>Nama Karyawan</th>
            <th>Total Insentif</th>
            <th>Tanggal Verifikasi</th>
            <th>Nama Verifikator</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator FROM pengajuan_insentif_borongan p
          INNER JOIN insentif i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE i.id_pengirim=?";
          $stmt = $db->prepare($selectSql);
          $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_insentif']);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $selectSql = "SELECT p.*, i.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator , SUM(i.bongkar+i.ontime) total_insentif FROM pengajuan_insentif_borongan p
          INNER JOIN insentif i on p.id_insentif = i.id
          LEFT JOIN karyawan k1 on i.id_pengirim = k1.id
          LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE i.id_pengirim=?
          GROUP BY no_pengajuan ORDER BY tgl_pengajuan DESC";
            $stmt = $db->prepare($selectSql);
            $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_insentif']);
            $stmt->execute();
          }
          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['tgl_pengajuan'] ?></td>
              <td><a href="?page=rekapdetailpengajuaninsentif&no_pengajuan=<?= $row['no_pengajuan']; ?>"><?= $row['no_pengajuan'] ?></a></td>
              <td><?= $row['nama_pengirim'] ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['total_insentif'], 0, ',', '.') ?></td>
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
            </tr>
          <?php } ?>
        </tbody>
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
    $('#mytable').DataTable();
  });
</script>