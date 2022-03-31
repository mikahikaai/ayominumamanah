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
                <h1 class="m-0">Distribusi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Distribusi</li>
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
            <h3 class="card-title">Data Distribusi</h3>
            <a href="?page=distribusicreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover" style="white-space: nowrap; background-color: white; table-layout: fixed;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Perjalanan</th>
                        <th>Tanggal</th>
                        <th>Plat</th>
                        <th>Nama Driver</th>
                        <th>Nama Helper 1</th>
                        <th>Nama Helper 2</th>
                        <th>Tujuan 1</th>
                        <th>Tujuan 2</th>
                        <th>Tujuan 3</th>
                        <th>Total Cup</th>
                        <th>Total A330</th>
                        <th>Total A500</th>
                        <th>Total A600</th>
                        <th>Total Refill</th>
                        <th>Jam Berangkat</th>
                        <th>Estimasi Jam Datang</th>
                        <th>Aktual Jam Datang</th>
                        <th>Keterangan</th>
                        <th>Tanggal Validasi</th>
                        <th>Divalidasi Oleh</th>
                        <th style="display: flex;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();

                    $selectsql = 'SELECT a.*, d.*, k1.nama as supir, k1.upah_borongan usupir1, k2.nama helper1, k2.upah_borongan uhelper2, k3.nama helper2, k3.upah_borongan uhelper2, do1.nama distro1, do1.jarak jdistro1, do2.nama distro2, do2.jarak jdistro2, do3.nama distro3, do3.jarak jdistro3
                    FROM distribusi d INNER JOIN armada a on d.id_plat = a.id
                    LEFT JOIN karyawan k1 on d.driver = k1.id
                    LEFT JOIN karyawan k2 on d.helper_1 = k2.id
                    LEFT JOIN karyawan k3 on d.helper_2 = k3.id
                    LEFT JOIN distributor do1 on d.nama_pel_1 = do1.id_da
                    LEFT JOIN distributor do2 on d.nama_pel_2 = do2.id_da
                    LEFT JOIN distributor do3 on d.nama_pel_3 = do3.id_da
                    ORDER BY d.no_perjalanan asc; ';
                    $stmt = $db->prepare($selectsql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $supir = $row['supir'] == NULL ? '-' : $row['supir'];
                        $helper1 = $row['helper1'] == NULL ? '-' : $row['helper1'];
                        $helper2 = $row['helper2'] == NULL ? '-' : $row['helper2'];
                        $distro1 = $row['distro1'] == NULL ? '-' : $row['distro1'];
                        $distro2 = $row['distro2'] == NULL ? '-' : $row['distro2'];
                        $distro3 = $row['distro3'] == NULL ? '-' : $row['distro3'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['no_perjalanan'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['plat'], ' - ' ,$row['nama_mobil'];?></td>
                            <td><?= $supir ?></td>
                            <td><?= $helper1 ?></td>
                            <td><?= $helper2 ?></td>
                            <td><?= $distro1?></td>
                            <td><?= $distro2?></td>
                            <td><?= $distro3?></td>
                            <td>Total Cup</td>
                            <td>Total A330</td>
                            <td>Total A500</td>
                            <td>Total A600</td>
                            <td>Total Refill</td>
                            <td>Jam Berangkat</td>
                            <td>Estimasi Jam Datang</td>
                            <td>Aktual Jam Datang</td>
                            <td>Keterangan</td>
                            <td>Tanggal Validasi</td>
                            <td>Divalidasi Oleh</td>
                            <td>
                                <a href="?page=lokasiupdate&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=lokasidelete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm mr-1" onclick="javasript: return confirm('Konfirmasi data akan dihapus?');">
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
            },
        });
    });
</script>