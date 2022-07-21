<?php
include 'function.php';
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_validasi'])) {

	$cup1 = !empty($_POST['cup1']) ? $_POST['cup1'] : 0;
	$cup2 = !empty($_POST['cup2']) ? $_POST['cup2'] : 0;
	$cup3 = !empty($_POST['cup3']) ? $_POST['cup3'] : 0;
	$a3301 = !empty($_POST['a3301']) ? $_POST['a3301'] : 0;
	$a3302 = !empty($_POST['a3302']) ? $_POST['a3302'] : 0;
	$a3303 = !empty($_POST['a3303']) ? $_POST['a3303'] : 0;
	$a5001 = !empty($_POST['a5001']) ? $_POST['a5001'] : 0;
	$a5002 = !empty($_POST['a5002']) ? $_POST['a5002'] : 0;
	$a5003 = !empty($_POST['a5003']) ? $_POST['a5003'] : 0;
	$a6001 = !empty($_POST['a6001']) ? $_POST['a6001'] : 0;
	$a6002 = !empty($_POST['a6002']) ? $_POST['a6002'] : 0;
	$a6003 = !empty($_POST['a6003']) ? $_POST['a6003'] : 0;
	$refill1 = !empty($_POST['refill1']) ? $_POST['refill1'] : 0;
	$refill2 = !empty($_POST['refill2']) ? $_POST['refill2'] : 0;
	$refill3 = !empty($_POST['refill3']) ? $_POST['refill3'] : 0;

	$jumlah_cup = $cup1 + $cup2 + $cup3;
	$jumlah_330 = $a3301 + $a3302 + $a3303;
	$jumlah_500 = $a5001 + $a5002 + $a5003;
	$jumlah_600 = $a6001 + $a6002 + $a6003;
	$jumlah_refill = $refill1 + $refill2 + $refill3;

	$jarak1 = $_POST['jarak1'];
	$jarak2 = $_POST['jarak2'];
	$jarak3 = $_POST['jarak3'];

	$jarak_max = max($jarak1, $jarak2, $jarak3);

	$kateg = $_POST['kateg_mobil'];

	$updatesql = "UPDATE distribusi SET jam_datang=?, keterangan=?, tgl_validasi=?, validasi_oleh=?, status='1' WHERE id=? ";
	$stmt_update = $db->prepare($updatesql);
	$jam_datang_format = date_create_from_format('d/m/Y H.i.s', $_POST['jam_datang']);
	$jam_datang = $jam_datang_format->format('Y/m/d H:i:s');
	$tgl_validasi = date('Y-m-d H:i:s');
	$stmt_update->bindParam(1, $jam_datang);
	$stmt_update->bindParam(2, $_POST['keterangan']);
	$stmt_update->bindParam(3, $tgl_validasi);
	$stmt_update->bindParam(4, $_SESSION['id']);
	$stmt_update->bindParam(5, $_GET['id']);
	$stmt_update->execute();

	$array_tim_pengirim = array($_POST['driver'], !empty($_POST['helper_1']) ? $_POST['helper_1'] : NULL, !empty($_POST['helper_2']) ? $_POST['helper_2'] : NULL);
	// var_dump($array_tim_pengirim[0]);
	// var_dump($array_tim_pengirim[1]);
	// var_dump($array_tim_pengirim[2]);
	// die();
	$jumlah_tim_pengirim = count(array_filter($array_tim_pengirim)) ?? 0;

	$array_upah_tim_pengirim = array(!empty($_POST['usupir']) ? $_POST['usupir'] : 0, !empty($_POST['uhelper1']) ? $_POST['uhelper1'] : 0, !empty($_POST['uhelper2']) ? $_POST['uhelper2'] : 0);

	$durasi = round((strtotime($jam_datang) - strtotime($_POST['jam_berangkat2'])) / 3600, 1);

	for ($i = 0; $i < 3; $i++) {
		$ontime = date_create($_POST['jam_datang']) <= date_modify(date_create($_POST['estimasi_jam_datang2']), '+15 Minutes');
		$hitungInsentifOntime = $ontime ? hitungInsentifOntime($jarak_max, $kateg) : 0;
		$hitungInsentifBongkar = hitungInsentifBongkar($jumlah_cup, $jumlah_330, $jumlah_500, $jumlah_600, $jumlah_refill);
		$hitungUpah = hitungUpah($jarak_max, $array_upah_tim_pengirim[$i], $durasi);
		if (empty($array_tim_pengirim[$i])) {
			$hitungInsentifOntime = 0;
			$hitungInsentifBongkar = 0;
		}

		$select_id_gaji = "SELECT * FROM gaji WHERE id_distribusi=? LIMIT $i,1";
		$stmt_select_id_gaji = $db->prepare($select_id_gaji);
		$stmt_select_id_gaji->bindParam(1, $_POST['no_perjalanan']);
		$stmt_select_id_gaji->execute();
		$row_select_id_gaji = $stmt_select_id_gaji->fetch(PDO::FETCH_ASSOC);
		$id_gaji = $row_select_id_gaji['id'];

		$insert_gaji = "UPDATE gaji SET ontime= ?, bongkar=?, upah=? WHERE id=?";
		$stmt_insert_gaji = $db->prepare($insert_gaji);
		$stmt_insert_gaji->bindParam(1, $hitungInsentifOntime);
		$stmt_insert_gaji->bindParam(2, $hitungInsentifBongkar);
		$stmt_insert_gaji->bindParam(3, $hitungUpah);
		$stmt_insert_gaji->bindParam(4, $id_gaji);
		$stmt_insert_gaji->execute();
	}

	$sukses = true;

	if ($sukses) {
		$_SESSION['hasil_validasi'] = true;
		$_SESSION['pesan'] = "Berhasil Validasi Data";
	} else {
		$_SESSION['hasil_validasi'] = false;
		$_SESSION['pesan'] = "Gagal Validasi Data";
	}
	echo '<meta http-equiv="refresh" content="0;url=?page=distribusiread"/>';
	exit;
}

if (isset($_GET['id'])) {
	$selectsql = "SELECT a.*, d.*, d.id id_distribusi, k1.nama as supir, k1.upah_borongan usupir, k2.nama helper1, k2.upah_borongan uhelper1, k3.nama helper2, k3.upah_borongan uhelper2, do1.nama distro1, do1.jarak jdistro1, do2.nama distro2, do2.jarak jdistro2, do3.nama distro3, do3.jarak jdistro3
    FROM distribusi d INNER JOIN armada a on d.id_plat = a.id
    LEFT JOIN karyawan k1 on d.driver = k1.id
    LEFT JOIN karyawan k2 on d.helper_1 = k2.id
    LEFT JOIN karyawan k3 on d.helper_2 = k3.id
    LEFT JOIN distributor do1 on d.nama_pel_1 = do1.id
    LEFT JOIN distributor do2 on d.nama_pel_2 = do2.id
    LEFT JOIN distributor do3 on d.nama_pel_3 = do3.id
    WHERE d.id=?";
	$stmt = $db->prepare($selectsql);
	$stmt->bindParam(1, $_GET['id']);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Distribusi</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="?page=home">Home</a></li>
					<li class="breadcrumb-item"><a href="?page=distribusiread">Distribusi</a></li>
					<li class="breadcrumb-item active">Validasi Distribusi</li>
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
			<h3 class="card-title">Data Validasi Distribusi <br> No. Perjalanan : <span class="font-weight-bold"> [<?= $row['no_perjalanan']; ?>] </span></h3>
		</div>
		<div class="card-body">
			<form action="" method="post">
				<input type="hidden" value="<?= $row['id_distribusi']; ?>" name="no_perjalanan">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Tujuan 1</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="nama_pel_1">Distributor</label>
							<input type="text" name="nama_pel_1" class="form-control" value="<?= $row['distro1'] ?>" readonly>
							<input type="hidden" name="jarak1" class="form-control" value="<?= $row['jdistro1'] ?>" readonly>
						</div>
						<div class="row">
							<div class="col-md">
								<div class="form-group">
									<label for="cup1">Muatan Cup</label>
									<input type="number" name="cup1" class="form-control" value="<?= $row['cup1'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a3301">Muatan A330</label>
									<input type="number" name="a3301" class="form-control" value="<?= $row['a3301'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a5001">Muatan A500</label>
									<input type="number" name="a5001" class="form-control" value="<?= $row['a5001'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a6001">Muatan A600</label>
									<input type="number" name="a6001" class="form-control" value="<?= $row['a6001'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="refill1">Muatan Refill</label>
									<input type="number" name="refill1" class="form-control" value="<?= $row['refill1'] ?>" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Tujuan 2</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="nama_pel_2">Distributor</label>
							<input type="text" name="nama_pel_2" class="form-control" value="<?= $row['distro2'] ?>" readonly>
							<input type="hidden" name="jarak2" class="form-control" value="<?= $row['jdistro2'] ?>" readonly>
						</div>
						<div class="row">
							<div class="col-md">
								<div class="form-group">
									<label for="cup2">Muatan Cup</label>
									<input type="number" name="cup2" class="form-control" value="<?= $row['cup2'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a3302">Muatan A330</label>
									<input type="number" name="a3302" class="form-control" value="<?= $row['a3302'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a5002">Muatan A500</label>
									<input type="number" name="a5002" class="form-control" value="<?= $row['a5002'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a6002">Muatan A600</label>
									<input type="number" name="a6002" class="form-control" value="<?= $row['a6002'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="refill2">Muatan Refill</label>
									<input type="number" name="refill2" class="form-control" value="<?= $row['refill2'] ?>" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Tujuan 3</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="nama_pel_3">Distributor</label>
							<input type="text" name="nama_pel_3" class="form-control" value="<?= $row['distro3'] ?>" readonly>
							<input type="hidden" name="jarak3" class="form-control" value="<?= $row['jdistro3'] ?>" readonly>
						</div>
						<div class="row">
							<div class="col-md">
								<div class="form-group">
									<label for="cup3">Muatan Cup</label>
									<input type="number" name="cup3" class="form-control" value="<?= $row['cup3'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a3303">Muatan A330</label>
									<input type="number" name="a3303" class="form-control" value="<?= $row['a3303'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a5003">Muatan A500</label>
									<input type="number" name="a5003" class="form-control" value="<?= $row['a5003'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="a6003">Muatan A600</label>
									<input type="number" name="a6003" class="form-control" value="<?= $row['a6003'] ?>" readonly>
								</div>
							</div>
							<div class="col-md">
								<div class="form-group">
									<label for="refill3">Muatan Refill</label>
									<input type="number" name="refill3" class="form-control" value="<?= $row['refill3'] ?>" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="id_plat">Armada</label>
					<input type="text" name="id_plat" class="form-control" value="<?= $row['plat'], " - ", $row['jenis_mobil']; ?>" readonly>
					<input type="hidden" name="kateg_mobil" class="form-control" value="<?= $row['kateg_mobil'] ?>" readonly>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Tim Pengirim</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="driver">Supir</label>
									<input type="text" name="driver" class="form-control" value="<?= $row['supir']; ?>" readonly>
									<input type="hidden" name="usupir" class="form-control" value="<?= $row['usupir']; ?>" readonly>
								</div>
								<div class="col-md-4">
									<label for="helper_1">Helper 1</label>
									<input type="text" name="helper_1" class="form-control" value="<?= $row['helper1']; ?>" readonly>
									<input type="hidden" name="uhelper1" class="form-control" value="<?= $row['uhelper1']; ?>" readonly>
								</div>
								<div class="col-md-4">
									<label for="helper_2">Helper 2</label>
									<input type="text" name="helper_2" class="form-control" value="<?= $row['helper2']; ?>" readonly>
									<input type="hidden" name="uhelper2" class="form-control" value="<?= $row['uhelper2']; ?>" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<label for="jam_berangkat">Jam Keberangkatan</label>
							<input type="text" name="jam_berangkat" class="form-control" value="<?= date('d/m/Y H:i:s', strtotime($row['jam_berangkat'])); ?>" readonly>
							<input type="hidden" name="jam_berangkat2" class="form-control" value="<?= $row['jam_berangkat']; ?>" readonly>
						</div>
						<div class="col-md-4">
							<label for="estimasi_jam_datang">Estimasi Kedatangan</label>
							<input type="text" name="estimasi_jam_datang" class="form-control" value="<?= date('d/m/Y H:i:s', strtotime($row['estimasi_jam_datang'])); ?>" readonly>
							<input type="hidden" name="estimasi_jam_datang2" class="form-control" value="<?= $row['estimasi_jam_datang']; ?>" readonly>
						</div>
						<div class="col-md-4">
							<label for="jam_datang">Jam Kedatangan (WAJIB DIISI)</label>
							<input id='datetimepicker1' type='text' class='form-control' data-td-target='#datetimepicker1' placeholder="dd/mm/yyyy hh:mm" name="jam_datang" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="keterangan">Keterangan</label>
					<input type="text" name="keterangan" class="form-control" placeholder="Isi hanya jika kedatangan tim pengiriman melebihi estimasi kedatangan">
				</div>
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input " type="checkbox" value="1" id="flexCheckDefault" name="bongkar" <?= $row['bongkar'] == 1 ? 'checked' : ''; ?> readonly>
						<label class="form-check-label text-bold" for="flexCheckDefault">
							Bongkar muatan?
						</label>
					</div>
				</div>
				<a href="?page=distribusiread" class="btn btn-danger btn-sm float-right">
					<i class="fa fa-arrow-left"></i> Kembali
				</a>
				<button type="submit" name="button_validasi" class="btn btn-success btn-sm float-right mr-1">
					<i class="fa fa-save"></i> Validasi
				</button>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$(":checkbox").bind("click", false);
		$("#datetimepicker1").keydown(function(event) {
			return false;
		});
	});
</script>
<!-- /.content -->