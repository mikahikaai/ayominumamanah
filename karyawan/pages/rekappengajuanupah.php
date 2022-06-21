<?php include_once "../partials/cssdatatables.php" ?>

<?php
$database = new Database;
$db = $database->getConnection();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pengajuan Upah</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item active">Pengajuan Upah</li>
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
      <h3 class="card-title">Data Upah Belum Terbayar</h3>
      <!-- <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a> -->
    </div>
    <div class="card-body">
      <form action="" method="post">
        <table id="mytable" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal Pengajuan</th>
              <th>No Pengajuan</th>
              <th>Total Upah</th>
              <th>Status</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $selectSql = "SELECT * FROM upah u
          INNER JOIN pengajuan_upah_borongan p ON p.id_upah = u.id
          WHERE p.terbayar='1'";
            // var_dump($tgl_rekap_awal);
            // var_dump($tgl_rekap_akhir);
            // die();
            $stmt = $db->prepare($selectSql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
              $selectSql = "SELECT p.*, u.*,k.*, d.*, SUM(upah) total_upah FROM pengajuan_upah_borongan p
          INNER JOIN upah u on p.id_upah = u.id
          INNER JOIN karyawan k on u.id_pengirim = k.id
          INNER JOIN distribusi d on u.id_distribusi = d.id
          WHERE u.id_pengirim = ?
          GROUP BY no_pengajuan ORDER BY no_pengajuan DESC";
              $stmt = $db->prepare($selectSql);
              $stmt->bindParam(1, $_SESSION['id']);
              $stmt->execute();
            }

            $no = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['tgl_pengajuan'] ?></td>
                <td><?= $row['no_pengajuan']; ?></td>
                <td style="text-align: right;"><?= 'Rp. ' . number_format($row['total_upah'], 0, ',', '.') ?></td>
                <td>
                  <?php
                  if ($row['terbayar'] == '0') {
                    echo '<span class="text-primary">Belum</span>';
                  } else if ($row['terbayar'] == '1') {
                    echo '<span class="text-danger">Menunggu Verifikasi</span>';
                  } else if ($row['terbayar'] == '2') {
                    echo '<span class="text-success">Terverifikasi</span>';
                  }
                  ?>
                </td>
                <td><a href="?page=rekapdetailpengajuanupah&no_pengajuan=<?= $row['no_pengajuan']; ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-eye"></i> Detail
                  </a>
                </td>
                <!-- <td>
                  <input type="hidden" name="no_pengajuan[]" value="<?= $row['no_pengajuan']; ?>">
                  <button type="submit" class="btn btn-sm btn-primary" name="ajukan">
                    <i class="fa fa-eye"></i> Detail
                  </button>
                </td> -->
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
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