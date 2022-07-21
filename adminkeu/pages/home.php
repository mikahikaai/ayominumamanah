<!-- Content Header (Page header) -->
<?php
$database = new Database;
$db = $database->getConnection();

$tahun = date('Y');
$tanggal_awal = date_create($tahun . '-01-01')->setTime(0, 0, 0);
$tanggal_akhir = date_create($tahun . '-12-31')->setTime(23, 59, 59);

//rekap upah
$_SESSION['tgl_rekap_awal_upah'] = $tanggal_awal;
$_SESSION['tgl_rekap_akhir_upah'] = $tanggal_akhir;
$_SESSION['id_karyawan_rekap_upah'] = 'all';

//rekap insentif
$_SESSION['tgl_rekap_insentif_awal'] = $tanggal_awal;
$_SESSION['tgl_rekap_insentif_akhir'] = $tanggal_akhir;
$_SESSION['id_karyawan_rekap_insentif'] = 'all';

//pengajuan insentif
$_SESSION['tgl_pengajuan_insentif_awal'] = $tanggal_awal;
$_SESSION['tgl_pengajuan_insentif_akhir'] = $tanggal_akhir;

$arrayChartUpah = [];
for ($i = 1; $i <= 12; $i++) {
  $selectChartUpah = "SELECT MONTH(d.jam_berangkat), k.nama, SUM(u.upah) total_upah FROM gaji u
  LEFT JOIN pengajuan_upah_borongan p ON p.id_upah = u.id
  INNER JOIN karyawan k ON u.id_pengirim = k.id
  INNER JOIN distribusi d ON u.id_distribusi = d.id
  WHERE MONTH(d.jam_berangkat) = ? AND YEAR(d.jam_berangkat) = ? AND terbayar='2'
  GROUP BY MONTH(d.jam_berangkat)";
  $stmtChartUpah = $db->prepare($selectChartUpah);
  $stmtChartUpah->bindParam(1, $i);
  $stmtChartUpah->bindParam(2, $tahun);
  $stmtChartUpah->execute();
  $rowChartUpah = $stmtChartUpah->fetch(PDO::FETCH_ASSOC);
  if ($stmtChartUpah->rowCount() == 0) {
    array_push($arrayChartUpah, 0);
  } else {
    array_push($arrayChartUpah, (int) $rowChartUpah['total_upah']);
  }
}

$arrayChartInsentif = [];
for ($i = 1; $i <= 12; $i++) {
  $selectChartInsentif = "SELECT MONTH(d.jam_berangkat), k.nama, sum(u.bongkar+u.ontime) total_insentif FROM gaji u
  LEFT JOIN pengajuan_insentif_borongan p ON p.id_insentif = u.id
  INNER JOIN karyawan k ON u.id_pengirim = k.id
  INNER JOIN distribusi d ON u.id_distribusi = d.id
  WHERE MONTH(d.jam_berangkat) = ? AND YEAR(d.jam_berangkat) = ? AND terbayar='2'
  GROUP BY MONTH(d.jam_berangkat)";
  $stmtChartInsentif = $db->prepare($selectChartInsentif);
  $stmtChartInsentif->bindParam(1, $i);
  $stmtChartInsentif->bindParam(2, $tahun);
  // $stmtChartInsentif->debugDumpParams();
  // die();
  $stmtChartInsentif->execute();
  $rowChartInsentif = $stmtChartInsentif->fetch(PDO::FETCH_ASSOC);
  if ($stmtChartInsentif->rowCount() == 0) {
    array_push($arrayChartInsentif, 0);
  } else {
    array_push($arrayChartInsentif, (int) $rowChartInsentif['total_insentif']);
  }
}

$tanggalBatasAwal = $tanggal_awal->format('Y-m-d H:i:s');
$tanggalBatasAkhir = $tanggal_akhir->format('Y-m-d H:i:s');

$selectAkumulasiUpah = "SELECT SUM(upah) total_upah FROM gaji g
LEFT JOIN pengajuan_upah_borongan p ON g.id = p.id_upah
INNER JOIN distribusi d ON d.id = g.id_distribusi
WHERE terbayar='2' AND (jam_berangkat BETWEEN ? AND ?)";
$stmtAkumulasiUpah = $db->prepare($selectAkumulasiUpah);
$stmtAkumulasiUpah->bindParam(1, $tanggalBatasAwal);
$stmtAkumulasiUpah->bindParam(2, $tanggalBatasAkhir);
$stmtAkumulasiUpah->execute();
$rowAkumulasiUpah = $stmtAkumulasiUpah->fetch(PDO::FETCH_ASSOC);

$selectAkumulasiInsentif = "SELECT SUM(g.bongkar+g.ontime) total_insentif FROM gaji g
LEFT JOIN pengajuan_insentif_borongan p ON g.id = p.id_insentif
INNER JOIN distribusi d ON d.id = g.id_distribusi
WHERE terbayar='2' AND (jam_berangkat BETWEEN ? AND ?)";
$stmtAkumulasiInsentif = $db->prepare($selectAkumulasiInsentif);
$stmtAkumulasiInsentif->bindParam(1, $tanggalBatasAwal);
$stmtAkumulasiInsentif->bindParam(2, $tanggalBatasAkhir);
$stmtAkumulasiInsentif->execute();
$rowAkumulasiInsentif = $stmtAkumulasiInsentif->fetch(PDO::FETCH_ASSOC);

$selectAkumulasiUpahBelumPengajuan = "SELECT p.*, u.*, d.*, SUM(upah) total_upah FROM pengajuan_upah_borongan p
RIGHT JOIN gaji u on p.id_upah = u.id
INNER JOIN distribusi d on u.id_distribusi = d.id
WHERE p.terbayar IS NULL AND d.jam_datang IS NOT NULL";
$stmtAkumulasiUpahBelumPengajuan = $db->prepare($selectAkumulasiUpahBelumPengajuan);
$stmtAkumulasiUpahBelumPengajuan->execute();
$rowAkumulasiUpahBelumPengajuan = $stmtAkumulasiUpahBelumPengajuan->fetch(PDO::FETCH_ASSOC);

$selectAkumulasiInsentifBelumPengajuan = "SELECT p.*, u.*, d.*, SUM(u.bongkar+u.ontime) total_insentif FROM pengajuan_insentif_borongan p
RIGHT JOIN gaji u on p.id_insentif = u.id
INNER JOIN distribusi d on u.id_distribusi = d.id
WHERE p.terbayar IS NULL AND d.jam_datang IS NOT NULL";
$stmtAkumulasiInsentifBelumPengajuan = $db->prepare($selectAkumulasiInsentifBelumPengajuan);
$stmtAkumulasiInsentifBelumPengajuan->execute();
$rowAkumulasiInsentifBelumPengajuan = $stmtAkumulasiInsentifBelumPengajuan->fetch(PDO::FETCH_ASSOC);

$selectsql = "SELECT a.*, d.*, k1.nama as supir, k1.upah_borongan usupir1, k2.nama helper1, k2.upah_borongan uhelper2, k3.nama helper2, k3.upah_borongan uhelper2, do1.nama distro1, do1.jarak jdistro1, do2.nama distro2, do2.jarak jdistro2, do3.nama distro3, do3.jarak jdistro3
FROM distribusi d INNER JOIN armada a on d.id_plat = a.id
LEFT JOIN karyawan k1 on d.driver = k1.id
LEFT JOIN karyawan k2 on d.helper_1 = k2.id
LEFT JOIN karyawan k3 on d.helper_2 = k3.id
LEFT JOIN distributor do1 on d.nama_pel_1 = do1.id
LEFT JOIN distributor do2 on d.nama_pel_2 = do2.id
LEFT JOIN distributor do3 on d.nama_pel_3 = do3.id
WHERE jam_datang IS NULL
ORDER BY estimasi_jam_datang DESC; ";
$stmt = $db->prepare($selectsql);
$stmt->execute();
$num_rows = $stmt->rowCount();

if (isset($_SESSION['hasil_update_pw'])) {
  if ($_SESSION['hasil_update_pw']) {
?>
    <div id='hasil_update_pw'></div>
  <?php
  }
  unset($_SESSION['hasil_update_pw']);
}

if (isset($_SESSION['login_sukses'])) {
  if ($_SESSION['login_sukses']) {
  ?>
    <div id='login_sukses'></div>
<?php
  }
  unset($_SESSION['login_sukses']);
}



?>

<!-- Main content -->
<div class="content pt-3">
  <div class="container-fluid">
    <h3># Rangkuman Informasi (Tahun <?= date('Y') ?>)</h3>
    <div class="row mt-3">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= 'Rp. ' . number_format($rowAkumulasiUpah['total_upah'], 0, ',', '.') ?></h3>
            <p>Akumulasi Upah Diterima</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-money-check-dollar"></i>
          </div>
          <a href="?page=rekapupah" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= 'Rp. ' . number_format($rowAkumulasiInsentif['total_insentif'], 0, ',', '.') ?></h3>
            <p>Akumulasi Insentif Diterima</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-money-check-dollar"></i>
          </div>
          <a href="?page=rekapinsentif" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= 'Rp. ' . number_format($rowAkumulasiUpahBelumPengajuan['total_upah'], 0, ',', '.') ?></h3>
            <p>Akumulasi Belum Pengajuan Upah</p>
          </div>
          <div class="icon">
            <i class="fas fa-sack-dollar"></i>
          </div>
          <a href="?page=upahbelumdiajukan" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= 'Rp. ' . number_format($rowAkumulasiInsentifBelumPengajuan['total_insentif'], 0, ',', '.') ?></h3>
            <p>Akumulasi Belum Pengajuan Insentif</p>
          </div>
          <div class="icon">
            <i class="fas fa-sack-dollar"></i>
          </div>
          <a href="?page=pengajuaninsentif" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <div class="row">
      <div class="col-6">
        <h3 class="mb-3"># Dalam Perjalanan </h3>
      </div>
      <div class="col-6 text-right">
        <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
          <i class="fa fa-arrow-left"></i>
        </a>
        <a class="btn btn-primary mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
      <div class="col-12">
        <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php
            $no = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              // var_dump($no);
              // die();
              $supir = $row['supir'] == NULL ? '-' : $row['supir'];
              $helper1 = $row['helper1'] == NULL ? '-' : $row['helper1'];
              $helper2 = $row['helper2'] == NULL ? '-' : $row['helper2'];
              $distro1 = $row['distro1'] == NULL ? '-' : $row['distro1'];
              $distro2 = $row['distro2'] == NULL ? '-' : $row['distro2'];
              $distro3 = $row['distro3'] == NULL ? '-' : $row['distro3'];
              $bongkar = $row['bongkar'] == 0 ? 'TIDAK' : 'YA';
              $total_cup = $row['cup1'] + $row['cup2'] + $row['cup3'];
              $total_330 = $row['a3301'] + $row['a3302'] + $row['a3303'];
              $total_500 = $row['a5001'] + $row['a5002'] + $row['a5003'];
              $total_600 = $row['a6001'] + $row['a6002'] + $row['a6003'];
              $total_refill = $row['refill1'] + $row['refill2'] + $row['refill3'];
              $estimasi_lama_perjalanan = date_diff(date_create($row['jam_berangkat']), date_create($row['estimasi_jam_datang']))->format('%d Hari %h Jam %i Menit %s Detik');
              if ($no == 1) {
                echo  "<div class='carousel-item active'>";
                echo  '<div class="row">';
              } else if ($no % 4 == 1) {
                echo  "<div class='carousel-item'>";
                echo  '<div class="row">';
              }
            ?>
              <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                  <h5 class="card-header bg-info"><?= $row['no_perjalanan']; ?></h5>
                  <div class="card-body">
                    <p class="card-text">Tujuan :<br> <?= implode(", ", array_filter(array($row['distro1'], $row['distro2'], $row['distro3']))); ?></p>
                    <p class="card-text">Tim Pengirim :<br> <?= implode(", ", array_filter(array($row['supir'], $row['helper1'], $row['helper2']))); ?> </p>
                    <p class="card-text">Muatan :<br>Cup = <?= $total_cup; ?>, A330 = <?= $total_330 ?>, A500 = <?= $total_500 ?>, A600 = <?= $total_600 ?>, Refill = <?= $total_refill ?> </p>
                    <p class="card-text">Jam Berangkat :<br> <?= tanggal_indo($row['jam_berangkat']); ?> </p>
                    <p class="card-text">Estimasi Lama Perjalanan : <br> <?= $estimasi_lama_perjalanan; ?></p>
                    <p class="card-text">Estimasi Datang :<br> <?= tanggal_indo($row['estimasi_jam_datang']); ?> </p>
                  </div>
                  <a href="?page=distribusiupdate&id=<?= $row['id']; ?>" class="btn btn-info d-block">Ubah <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php
              if ($no % 4 == 0 or $no == $num_rows) {
                echo  '</div>';
                echo  '</div>';
              }
              $no++;
            }
            ?>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <div class="row">
      <div class="col-md-6">
        <h3 class="mb-3"># Data Grafik Upah Karyawan Tahun <?= date('Y'); ?> </h3>
        <canvas id="myChart"></canvas>
      </div>
      <div class="col-md-6">
        <h3 class="mb-3"># Data Grafik Insentif Karyawan Tahun <?= date('Y'); ?> </h3>
        <canvas id="myChart2"></canvas>
      </div>
    </div>
  </div>
</div>

<?php
include_once "../partials/scriptdatatables.php";
?>

<script>
  // Get cards
  var cards = $('.card-body');
  var maxHeight = 0;

  // Loop all cards and check height, if bigger than max then save it
  for (var i = 0; i < cards.length; i++) {
    if (maxHeight < $(cards[i]).outerHeight()) {
      maxHeight = $(cards[i]).outerHeight();
    }
  }
  // Set ALL card bodies to this height
  for (var i = 0; i < cards.length; i++) {
    $(cards[i]).height(maxHeight);
  }

  if ($('div#hasil_update_pw').length) {
    Swal.fire({
      title: 'Updated!',
      text: 'Password berhasil diubah',
      icon: 'success',
      confirmButtonText: 'OK'
    })
  }

  if ($('div#login_sukses').length) {
    let timerInterval
    let nama = "<?= ucfirst($_SESSION['nama']); ?>"
    Swal.fire({
      width: 'auto',
      showConfirmButton: false,
      position: 'top-end',
      html: '<h5>Selamat Datang ' + nama + ' !</h5>',
      timer: 2000,
      timerProgressBar: true,

      willClose: () => {
        clearInterval(timerInterval)
      }
    })
  };

  // $().ready(function() {
  //   let timerInterval
  //   let nama = "<?= ucfirst($_SESSION['nama']); ?>"
  //   Swal.fire({
  //     showConfirmButton: false,
  //     width: 'auto',
  //     position: 'top-end',
  //     html: '<h5>Selamat Datang ' + nama + ' !</h5>',
  //     timer: 3000,
  //     timerProgressBar: true,

  //     willClose: () => {
  //       clearInterval(timerInterval)
  //     }
  //   })
  // });

  //chart upah
  var arrayIndicator = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  var arrayChartUpah = <?= json_encode($arrayChartUpah); ?>;
  var arrayBackground1 = [];
  var arrayBorder1 = [];

  for (let i = 0; i < arrayIndicator.length; i++) {
    r = Math.floor(Math.random() * 255);
    g = Math.floor(Math.random() * 255);
    b = Math.floor(Math.random() * 255);
    arrayBackground1.push('rgba(' + r + ', ' + g + ', ' + b + ', ' + '0.2)');
    arrayBorder1.push('rgba(' + r + ', ' + g + ', ' + b + ', ' + '1)');
  }

  Chart.Legend.prototype.afterFit = function() {
    this.height = this.height + 10;
  };

  const ctxUpah = document.getElementById('myChart').getContext('2d');
  const myChartUpah = new Chart(ctxUpah, {
    type: 'bar',
    data: {
      labels: arrayIndicator,
      datasets: [{
        label: '# Jumlah Upah Tahun ' + new Date().getFullYear(),
        data: arrayChartUpah,
        backgroundColor: arrayBackground1,
        borderColor: arrayBorder1,
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        labels: {
          render: 'value',
          precision: 2
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  //chart insentif
  var arrayChartInsentif = <?= json_encode($arrayChartInsentif); ?>;
  const ctxInsentif = document.getElementById('myChart2').getContext('2d');
  const myChartInsentif = new Chart(ctxInsentif, {
    type: 'bar',
    data: {
      labels: arrayIndicator,
      datasets: [{
        label: '# Jumlah Insentif Tahun ' + new Date().getFullYear(),
        data: arrayChartInsentif,
        backgroundColor: arrayBackground1,
        borderColor: arrayBorder1,
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        labels: {
          render: 'value',
          precision: 2
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<!-- /.content -->