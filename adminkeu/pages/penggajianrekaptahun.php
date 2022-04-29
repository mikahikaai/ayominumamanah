<?php include_once "partials/cssdatatables.php";

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Rekapitulasi Penggajian Bulanan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=penggajianrekap">Rekap Gaji</a></li>
                    <li class="breadcrumb-item active"><?= $_GET['tahun'] ?></li>
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
            <h3 class="card-title">Data Rekap Gaji Tahun <?= $_GET['tahun'] ?></h3>
            <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Export PDF
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Bulan</th>
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
                    
                    $selectSql = "SELECT bulan, SUM(p.gapok) jumlah_gapok, SUM(p.tunjangan) jumlah_tunjangan, SUM(p.uang_makan) jumlah_uang_makan,
                    SUM(p.gapok) + sum(p.tunjangan) + sum(p.uang_makan) total from penggajian p WHERE tahun=? GROUP BY bulan";
                    $stmt = $db->prepare($selectSql);
                    $stmt->bindParam(1, $_GET['tahun']);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['bulan'] ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_gapok']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_tunjangan']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['jumlah_uang_makan']) ?></td>
                            <td style="text-align: right;"><?= number_format($row['total']) ?></td>
                            <td>
                                <a href="?page=penggajianrekapbulan&tahun=<?= $_GET['tahun'] ?>&bulan=<?= $row['bulan']; ?>" class="btn btn-primary btn-sm mr-1">
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
        $('#mytable').DataTable();
    });
</script>