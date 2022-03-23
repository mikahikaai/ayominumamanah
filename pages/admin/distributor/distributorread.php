<?php include_once "partials/cssdatatables.php" ?>

<?php
if (isset($_SESSION['hasil'])) {
?>
    <?php if ($_SESSION['hasil']) {
    ?>
        <div class="alert alert-success alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-check"></i>Sukses</h5>
            <?= $_SESSION['pesan'] ?>
        </div>

    <?php
    } else {
    ?>
        <div class="alert alert-danger alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-times"></i>Terjadi Kesalahan</h5>
            <?= $_SESSION['pesan'] ?>
        </div>
<?php }
    unset($_SESSION['hasil']);
    unset($_SESSION['pesan']);
} ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Distributor</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Distributor</li>
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
            <h3 class="card-title">Data Distributor</h3>
            <a href="?page=distributorcreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover" style="white-space: nowrap; background-color: white; width: 100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th>ID Distributor</th>
                        <th>Paket</th>
                        <th>Alamat Dropping</th>
                        <th>No. Telepon</th>
                        <th>Jarak</th>
                        <th>Kateg</th>
                        <th>Minimal Order</th>
                        <th>Ongkir</th>
                        <th>Status Keaktifan</th>
                        <th style="display: flex;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();

                    $selectsql = 'SELECT * FROM distributor order by nama asc';
                    $stmt = $db->prepare($selectsql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // $str = $row['alamat_dropping'];
                        // if (strlen($str) > 80)
                        //     $str = substr($str, 0, 77) . '...';
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['id_da'] ?></td>
                            <td><?= $row['paket'] ?></td>
                            <td><?= $row['alamat_dropping'] ?></td>
                            <td><?= $row['no_telepon'] ?></td>
                            <td><?= $row['jarak'] ?></td>
                            <td><?= $row['kateg'] ?></td>
                            <td><?= $row['min_order'] ?></td>
                            <td><?= $row['ongkir'] ?></td>
                            <td><?= $row['status_keaktifan'] ?></td>
                            <td>
                                <a href="?page=distributorupdate&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=distributordelete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm mr-1" onclick="javasript: return confirm('Konfirmasi data akan dihapus?');">
                                    <i class="fa fa-trash"></i> Hapus
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
        $(document).on({
            mouseenter: function() {
                trIndex = $(this).index() + 1;
                $("table.dataTable").each(function(index) {
                    $(this).find("tr:eq(" + trIndex + ")").each(function(index) {
                        $(this).find("td").addClass("hover");
                    });
                });
            },
            mouseleave: function() {
                trIndex = $(this).index() + 1;
                $("table.dataTable").each(function(index) {
                    $(this).find("tr:eq(" + trIndex + ")").each(function(index) {
                        $(this).find("td").removeClass("hover");
                    });
                });
            }
        }, ".dataTables_wrapper tr");
        $('#mytable').DataTable({
            pagingType: "full_numbers",
            stateSave: true,
            stateDuration: 60,
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 1
            }            
        });
    });
</script>