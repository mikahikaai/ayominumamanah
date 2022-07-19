<?php
session_start();
include "../../database/database.php";

$database = new Database;
$db = $database->getConnection();

$selectSql = "SELECT * FROM karyawan WHERE jabatan='HELPER' OR jabatan='DRIVER'";
$stmt = $db->prepare($selectSql);
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
    <td align="center" style="font-weight: bold; padding-bottom: 20px; font-size: x-large;"><u>DATA KARYAWAN</u></td>
  </tr>
</table>

<!-- content dibawah header -->
<!-- <table id="content1">
  <tr>
    <td width="20%">Nama Karyawan</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $row1['nama'] ?></td>
    <td width="25%" align="right"></td>
  </tr>
  <tr>
    <td width="20%">Periode Upah</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= tanggal_indo($_SESSION['tgl_rekap_awal_upah']->format('Y-m-d')) . " sd " . tanggal_indo($_SESSION['tgl_rekap_akhir_upah']->format('Y-m-d')) ?></td>
    <td width="25%" align="right"></td>
  </tr>
</table> -->
<!-- end content diatas header -->

<!-- content -->
<table id="content">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>NIK</th>
      <th>Tempat, Tanggal Lahir</th>
      <th>Alamat</th>
      <th>Jabatan</th>
      <th>No Telp</th>
      <th>Status Keaktifan</th>
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
        <td><?= $row['nik'] ?></td>
        <td><?= $row['tempat_lahir'] . ", " . tanggal_indo($row['tanggal_lahir'])?></td>
        <td><?= $row['alamat'] ?></td>
        <td><?= $row['jabatan'] ?></td>
        <td><?= $row['no_telepon'] ?></td>
        <td><?= $row['status_keaktifan'] ?></td>
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