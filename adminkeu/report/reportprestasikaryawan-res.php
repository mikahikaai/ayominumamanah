<?php
session_start();
include "../../database/database.php";

$database = new Database;
$db = $database->getConnection();

$tgl_rekap_awal = $_SESSION['tgl_prestasi_awal']->format('Y-m-d H:i:s');
$tgl_rekap_akhir = $_SESSION['tgl_prestasi_akhir']->format('Y-m-d H:i:s');

$selectSql = "SELECT k1.nama, COUNT(k1.nama) total_berangkat, k1.id id_karyawan,
    (SELECT COUNT(*) FROM gaji u LEFT JOIN distribusi d ON u.id_distribusi = d.id 
    INNER JOIN karyawan k ON k.id = u.id_pengirim WHERE d.jam_datang > d.estimasi_jam_datang + INTERVAL 15 MINUTE AND k.id = k1.id AND (d.jam_berangkat BETWEEN ? AND ?)) tidak_tepat_waktu ,
    (SELECT COUNT(*) FROM gaji u LEFT JOIN distribusi d ON u.id_distribusi = d.id 
    INNER JOIN karyawan k ON k.id = u.id_pengirim WHERE d.jam_datang <= d.estimasi_jam_datang + INTERVAL 15 MINUTE AND k.id = k1.id AND (d.jam_berangkat BETWEEN ? AND ?)) tepat_waktu
    FROM gaji u
    LEFT JOIN distribusi d ON u.id_distribusi = d.id 
    INNER JOIN karyawan k1 ON k1.id = u.id_pengirim
    WHERE (d.jam_berangkat BETWEEN ? AND ?) AND d.jam_datang IS NOT NULL AND k1.id = IF(? = 'all', k1.id, ?) 
    GROUP BY k1.nama ORDER BY k1.nama ASC";
$stmt = $db->prepare($selectSql);
$stmt->bindParam(1, $tgl_rekap_awal);
$stmt->bindParam(2, $tgl_rekap_akhir);
$stmt->bindParam(3, $tgl_rekap_awal);
$stmt->bindParam(4, $tgl_rekap_akhir);
$stmt->bindParam(5, $tgl_rekap_awal);
$stmt->bindParam(6, $tgl_rekap_akhir);
$stmt->bindParam(7, $_SESSION['id_karyawan_prestasi']);
$stmt->bindParam(8, $_SESSION['id_karyawan_prestasi']);
$stmt->execute();
?>
<style>
  table#content {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    /* table-layout: fixed; */
    width: 100%;
    margin-bottom: 30px;
  }

  table#content th {
    border: 1px solid grey;
    padding: 8px;
    text-align: center;
    width: fit-content;
    background-color: #5a5e5a;
    color: white;

  }

  table#content td {
    border: 1px solid grey;
    padding: 8px;
  }

  table#content tbody tr:nth-child(even) {
    background-color: #e4ede4;
  }

  table#content1 {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
  }

  table#content1 td {
    /* border: 1px solid black; */
    padding-bottom: 10px;
  }

  table#summary {
    width: 100%;
    border-collapse: collapse;
  }
</style>

<!-- header -->

<table style="width: 100%; margin-bottom: 10px;">
  <tr>
    <td align="center" style="font-weight: bold; padding-bottom: 20px; font-size: x-large;"><u>DATA PRESTASI KEBERANGKATAN</u></td>
  </tr>
</table>

<!-- content dibawah header -->
<table id="content1">
  <!-- <tr>
    <td width="20%">Nama Karyawan</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $row1['nama'] ?></td>
    <td width="25%" align="right"></td>
  </tr> -->
  <tr>
    <td width="20%">Periode Keberangkatan</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= tanggal_indo($_SESSION['tgl_prestasi_awal']->format('Y-m-d')) . " sd " . tanggal_indo($_SESSION['tgl_prestasi_akhir']->format('Y-m-d')) ?></td>
    <td width="25%" align="right"></td>
  </tr>
</table>
<!-- end content diatas header -->

<!-- content -->
<table id="content">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Total Berangkat</th>
      <th>Tepat Waktu</th>
      <th>Terlambat</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $no = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama'] ?></td>
        <td align="right"><?= $row['total_berangkat'] ?></td>
        <td><?= $row['tepat_waktu'] . "x (" . (round($row['tepat_waktu'] / $row['total_berangkat'], 2)) * 100 . "%)" ?></td>
        <td><?= $row['tidak_tepat_waktu'] . "x (" . (round($row['tidak_tepat_waktu'] / $row['total_berangkat'], 2)) * 100 . "%)" ?></td>
        <td>
          <?php
          if ($row['tepat_waktu'] / $row['total_berangkat'] >= 0.8) {
            echo "<div style='color: green;'>Sangat Baik</div>";
          } else if ($row['tepat_waktu'] / $row['total_berangkat'] >= 0.6 and $row['tepat_waktu'] / $row['total_berangkat'] < 0.8) {
            echo "<div style='color: blue;'>Baik</div>";
          } else if ($row['tepat_waktu'] / $row['total_berangkat'] >= 0.3 and $row['tepat_waktu'] / $row['total_berangkat'] < 0.6) {
            echo "<div style='color: orange;'>Buruk</div>";
          } else if ($row['tepat_waktu'] / $row['total_berangkat'] < 0.3) {
            echo "<div style='color: red;'>Sangat Buruk</div>";
          }
          ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<!-- end content -->

<!-- summary -->

<table id="summary" style="page-break-inside: avoid;" autosize="1">
  <tr>
    <td width="70%"></td>
    <td align="center">Banjarbaru, <?= tanggal_indo(date('Y-m-d')) ?></td>
  </tr>
  <tr>
    <td width=" 70%"></td>
    <td><br><br><br><br><br><br><br></td>
  </tr>
  <tr>
    <td width="70%"></td>
    <td align="center"><u><b><?= $_SESSION['nama'] ?></b></u></td>
  </tr>
</table>

<!-- end summary -->

<!-- footer -->
<!-- end footer -->

<?php
function tanggal_indo($tanggal, $cetak_hari = false)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split     = explode('-', $tanggal);
  $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

  if ($cetak_hari) {
    $num = date('N', strtotime($tanggal));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}
?>