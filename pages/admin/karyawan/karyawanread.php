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
                <h1 class="m-0">Karyawan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Karyawan</li>
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
            <h3 class="card-title">Data Karyawan</h3>
            <a href="?page=karyawancreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Bagian</th>
                        <th>Jabatan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();

                    $selectsql = 'SELECT K.*,
                    (SELECT J.nama_jabatan FROM jabatan_karyawan JK INNER JOIN jabatan J on JK.jabatan_id = J.id
                    WHERE JK.karyawan_id = K.id ORDER BY JK.tanggal_mulai DESC LIMIT 1) jabatan_terkini,
                    (SELECT B.nama_bagian FROM bagian_karyawan BK INNER JOIN bagian B on BK.bagian_id = B.id
                    WHERE BK.karyawan_id = K.id ORDER BY BK.tanggal_mulai DESC LIMIT 1) bagian_terkini
                    FROM karyawan K';
                    $stmt = $db->prepare($selectsql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['nama_lengkap'] ?></td>
                            <td>
                                <?php
                                    $bagianterkini = $row['bagian_terkini'] ?? 'Belum Memiliki Bagian';
                                ?>
                                <a href="?page=karyawanbagian&id=<?= $row['id'] ?>" class="btn bg-fuchsia btn-sm mr-1 btn-block text-left">
                                <i class="fa fa-building mr-1"></i><?= $bagianterkini; ?></a>
                            </td>
                            <td>
                                <?php
                                    $jabatanterkini = $row['jabatan_terkini'] ?? 'Belum Memiliki Jabatan';
                                ?>
                                 <a href="?page=karyawanjabatan&id=<?= $row['id'] ?>" class="btn bg-lime btn-sm mr-1 btn-block text-left">
                                <i class="fa fa-building mr-1"></i><?= $jabatanterkini; ?></a>
                            </td>
                            <td>
                                <a href="?page=karyawanupdate&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=karyawandelete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm mr-1" onclick="javasript: return confirm('Konfirmasi data akan dihapus?');">
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