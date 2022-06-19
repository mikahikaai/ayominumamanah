<?php include_once "../partials/cssdatatables.php" ?>
<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_GET['idk'])) {
  $selectSql = "SELECT u.*, d.*, k.* FROM upah u
  INNER JOIN distribusi d on u.id_distribusi = d.id
  INNER JOIN karyawan k on u.id_pengirim = k.id
  WHERE u.id_pengirim = ?";
  $stmt = $db->prepare($selectSql);
  $stmt->bindParam(1, $_GET['idk']);
  $stmt->execute();
}

if (isset($_POST['verif'])){
  $updateSql = "UPDATE upah SET terbayar='2' WHERE id_pengirim=? AND terbayar='1'";
  $stmt_update = $db->prepare($updateSql);
  $stmt_update->bindParam(1, $_GET['idk']);
  $stmt_update->execute();

  echo '<meta http-equiv="refresh" content="0;url=?page=pengajuanupah"/>';
}
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
          <li class="breadcrumb-item active">Detail Upah</li>
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
      <h3 class="card-title">Data Detail Upah Belum Terbayar</h3>
      <!-- <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a> -->
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal & Jam Berangkat</th>
            <th>No Perjalanan</th>
            <th>Nama</th>
            <th>Upah</th>
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
              <td><a href="?page=detaildistribusi&id=<?= $row['id_distribusi'] ?>&idk=<?= $row['id_karyawan'] ?>"><?= $row['no_perjalanan'] ?></a></td>
              <td><?= $row['nama'] ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['upah'], 0, ',', '.') ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <form action="" method="post">
        <button type="submit" name="verif" class="btn btn-md float-right btn-success mt-2">Verifikasi</button>
      </form>
      <a href="?page=pengajuanupah" class="btn btn-md mt-2 btn-danger float-right mr-1">Kembali</a>
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
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');
  });
</script>