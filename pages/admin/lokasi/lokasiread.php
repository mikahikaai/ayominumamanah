<?php include_once "partials/cssdatatables.php" ?>
<!-- Content Header (Page header) -->
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

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lokasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Lokasi</li>
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
            <h3 class="card-title">Data Lokasi</h3>
            <a href="?page=lokasicreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lokasi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lokasi</th>
                        <th>Opsi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();

                    $selectsql = 'SELECT * FROM lokasi';
                    $stmt = $db->prepare($selectsql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_lokasi'] ?></td>
                            <td>
                                <a href="?page=lokasiupdate&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=lokasidelete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm mr-1"
                                onclick="javasript: return confirm('Konfirmasi data akan dihapus?');">
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
        $('#mytable').DataTable();
    });
</script>