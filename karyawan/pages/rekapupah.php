<?php include_once "../partials/cssdatatables.php" ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Rekapitulasi Upah</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Rekap Upah</li>
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
                        <th>Tanggal</th>
                        <th>No Perjalanan</th>
                        <th>Upah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();
                    
                    $selectSql = "SELECT * FROM upah u INNER JOIN distribusi d on u.no_perjalanan = d.no_perjalanan WHERE u.id_pengirim = ?";
                    $stmt = $db->prepare($selectSql);
                    $stmt->bindParam(1, $_SESSION['id']);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['no_perjalanan'] ?></td>
                            <td style="text-align: right;"><?= number_format($row['upah']) ?></td>
                            <!-- <td>
                                <a href="?page=penggajianrekaptahun&tahun=<?= $row['tahun']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-info"></i> Detail
                                </a>
                            </td> -->
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