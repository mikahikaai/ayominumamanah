<?php include_once "partials/cssdatatables.php" ?>

<?php
if (isset($_SESSION['hasil'])) {
    if ($_SESSION['hasil']) {
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
} elseif (isset($_SESSION['hasil_delete'])) {
    if ($_SESSION['hasil_delete']) {
    ?>
        <div id='hasil_delete'></div>
<?php }
    unset($_SESSION['hasil_delete']);
} elseif (isset($_SESSION['hasil_create'])) {
    if ($_SESSION['hasil_create']) {
    ?>
        <div id='hasil_create'></div>
<?php }
    unset($_SESSION['hasil_create']);
} elseif (isset($_SESSION['hasil_update'])) {
    if ($_SESSION['hasil_update']) {
    ?>
        <div id='hasil_update'></div>
<?php }
    unset($_SESSION['hasil_update']);
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
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
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
            <table id="mytable" class="table table-bordered table-hover" style="white-space: nowrap; background-color: white; table-layout: fixed;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>NIK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Agama</th>
                        <th>Status Kawin</th>
                        <th>Jabatan</th>
                        <th>No. Telpon</th>
                        <th>Golongan Darah</th>
                        <th>SIM</th>
                        <th>Status Karyawan</th>
                        <th>Tanggal Registrasi</th>
                        <th>Status Keaktifan</th>
                        <th>Upah</th>
                        <th style="display: flex;">Opsi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database;
                    $db = $database->getConnection();

                    $selectsql = 'SELECT * FROM karyawan';
                    $stmt = $db->prepare($selectsql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['password'] ?></td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['tempat_lahir'] ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_lahir'])) ?></td>
                            <td><?= $row['jenis_kelamin'] ?></td>
                            <td><?= strtoupper($row['alamat']) ?></td>
                            <td><?= $row['agama'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= $row['jabatan'] ?></td>
                            <td><?= $row['no_telepon'] ?></td>
                            <td><?= $row['gol_darah'] ?></td>
                            <td><?= $row['sim'] ?></td>
                            <td><?= $row['status_karyawan'] ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_registrasi'])) ?></td>
                            <td><?= $row['status_keaktifan'] ?></td>
                            <td><?= number_format($row['upah_borongan'], 0, ",", ".") ?></td>
                            <td>
                                <a href="?page=karyawanupdate&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=karyawandelete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm mr-1" id="deletekaryawan">
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
        $('a#deletekaryawan').click(function(e) {
            e.preventDefault();
            var urlToRedirect = e.currentTarget.getAttribute('href');
            //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = urlToRedirect;
                }
            })
        });
        if ($('div#hasil_delete').length) {
            Swal.fire({
                title: 'Deleted!',
                text: 'Data berhasil dihapus',
                icon: 'success',
                confirmButtonText: 'OK'
            })
        } else if ($('div#hasil_create').length) {
            Swal.fire({
                title: 'Created!',
                text: 'Data berhasil disimpan',
                icon: 'success',
                confirmButtonText: 'OK'
            })
        } else if ($('div#hasil_update').length) {
            Swal.fire({
                title: 'Updated!',
                text: 'Data berhasil diubah',
                icon: 'success',
                confirmButtonText: 'OK'
            })
        }
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