<?php include_once "partials/cssdatatables.php";

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Rekapitulasi Penggajian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item active"><a href="?page=penggajianrekap">Rekap Gaji</a></li>
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
            <h3 class="card-title">Data Rekap Gaji</h3>
            <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Export PDF
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tahun</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Uang Makan</th>
                        <th>Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();
                    
                    $selectSql = "SELECT tahun, SUM(p.gapok) jumlah_gapok, SUM(p.tunjangan) jumlah_tunjangan, SUM(p.uang_makan) jumlah_uang_makan,
                    SUM(p.gapok) + sum(p.tunjangan) + sum(p.uang_makan) total from penggajian p GROUP BY tahun";
                    $stmt = $db->prepare($selectSql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['tahun'] ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_gapok']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_tunjangan']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_uang_makan']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['total']) ?></td>
                            <td>
                                <a href="?page=penggajianrekaptahun&tahun=<?= $row['tahun']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-info"></i> Detail
                                </a>
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
include_once "partials/scriptdatatables.php";
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