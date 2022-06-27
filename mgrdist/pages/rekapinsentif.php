<?php include_once "../partials/cssdatatables.php" ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Rekapitulasi Insentif</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item active">Rekap Insentif</li>
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
      <h3 class="card-title">Data Rekap Insentif</h3>
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
            <th>Ontime</th>
            <th>Bongkar</th>
            <th>Terbayar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tgl_rekap_insentif_awal = $_SESSION['tgl_rekap_insentif_awal']->format('Y-m-d H:i:s');
          $tgl_rekap_insentif_akhir = $_SESSION['tgl_rekap_insentif_akhir']->format('Y-m-d H:i:s');
          $database = new Database;
          $db = $database->getConnection();

          $selectSql = "SELECT i.*, d.*, p.*, k.*, d.id id_distribusi, i.bongkar bongkar2 FROM gaji i
          INNER JOIN distribusi d ON i.id_distribusi = d.id
          LEFT JOIN pengajuan_insentif_borongan p ON p.id_insentif = i.id
          INNER JOIN karyawan k ON k.id = i.id_pengirim
          WHERE i.id_pengirim = ? AND (tanggal BETWEEN ? AND ?) AND terbayar='2'";
          // var_dump($tgl_rekap_awal);
          // var_dump($tgl_rekap_akhir);
          // die();
          $stmt = $db->prepare($selectSql);
          $stmt->bindParam(1, $_SESSION['id_karyawan_rekap_insentif']);
          $stmt->bindParam(2, $tgl_rekap_insentif_awal);
          $stmt->bindParam(3, $tgl_rekap_insentif_akhir);
          $stmt->execute();
          
          // var_dump($_SESSION['id_karyawan_rekap_insentif']);
          // die();

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // var_dump($row['bongkar']);
            // die();
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['tanggal'] ?></td>
              <td><a href="?page=detaildistribusi&id=<?= $row['id_distribusi'] ?>"><?= $row['no_perjalanan'] ?></a></td>
              <td><?= $row['nama'] ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['ontime'], 0, ',', '.'); ?></td>
              <td style="text-align: right;"><?= 'Rp. ' . number_format($row['bongkar2'], 0, ',', '.'); ?></td>
              <td>
                <?php
                if ($row['terbayar'] == '0') {
                  echo 'Belum';
                } else {
                  echo 'Sudah';
                }

                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

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