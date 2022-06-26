<?php include_once "../partials/cssdatatables.php" ?>

<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['ajukan'])) {
  $update_ajukan = "UPDATE pengajuan_upah_borongan SET terbayar = '2' WHERE terbayar='1' AND  ";
  $stmt_update = $db->prepare($update_ajukan);
  $stmt_update->bindParam(1, $_SESSION['id']);
  $stmt_update->execute();
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pengajuan Insentif</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item active">Pengajuan Insentif</li>
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
      <h3 class="card-title">Data Insentif Belum Terbayar</h3>
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
            <th>Nama</th>
            <th>Total Insentif</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $selectSql = "SELECT * FROM gaji i
          INNER JOIN pengajuan_insentif_borongan p ON p.id_insentif = i.id
          WHERE p.terbayar='1'";
          // var_dump($tgl_rekap_awal);
          // var_dump($tgl_rekap_akhir);
          // die();
          $stmt = $db->prepare($selectSql);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $selectSql = "SELECT p.*, i.*,k.*, d.*, SUM(i.bongkar+i.ontime) total_insentif FROM pengajuan_insentif_borongan p
          INNER JOIN gaji i on p.id_insentif = i.id
          INNER JOIN karyawan k on i.id_pengirim = k.id
          INNER JOIN distribusi d on i.id_distribusi = d.id
          WHERE p.terbayar='1' GROUP BY no_pengajuan";
            $stmt = $db->prepare($selectSql);
            $stmt->execute();
          }

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['tgl_pengajuan'] ?></td>
              <td><?= $row['no_pengajuan'] ?></td>
              <td><?= $row['nama'] ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['total_insentif'], 0, ',', '.') ?></td>
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
              <td>
                <a href="?page=detailpengajuaninsentif&no_pengajuan=<?= $row['no_pengajuan']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat</a>
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