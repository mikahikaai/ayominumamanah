<?php
session_start();
include "../../database/database.php";

date_default_timezone_set("Asia/Kuala_Lumpur");

$database = new Database;
$db = $database->getConnection();

$tgl_awal = $_SESSION['tgl_rekap_awal_pengajuan_upah']->format('Y-m-d H:i:s');
$tgl_akhir = $_SESSION['tgl_rekap_akhir_pengajuan_upah']->format('Y-m-d H:i:s');

$selectSql = "SELECT p.*, u.*, d.*, k1.nama nama_pengirim, k2.nama nama_verifikator , SUM(upah) total_upah FROM pengajuan_upah_borongan p
  INNER JOIN gaji u on p.id_upah = u.id
  LEFT JOIN karyawan k1 on u.id_pengirim = k1.id
  LEFT JOIN karyawan k2 on p.id_verifikator = k2.id
  INNER JOIN distribusi d on u.id_distribusi = d.id
  WHERE u.id_pengirim = IF (? = 'all', u.id_pengirim, ?) AND (p.tgl_pengajuan BETWEEN ? AND ?) AND p.terbayar = IF (? = 'all', p.terbayar, ?)
  GROUP BY no_pengajuan ORDER BY tgl_pengajuan ASC, no_pengajuan ASC";
$stmt = $db->prepare($selectSql);
$stmt->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_upah']);
$stmt->bindParam(2, $_SESSION['id_karyawan_rekap_pengajuan_upah']);
$stmt->bindParam(3, $tgl_awal);
$stmt->bindParam(4, $tgl_akhir);
$stmt->bindParam(5, $_SESSION['status_rekap_pengajuan_upah']);
$stmt->bindParam(6, $_SESSION['status_rekap_pengajuan_upah']);
$stmt->execute();

$stmt1 = $db->prepare($selectSql);
$stmt1->bindParam(1, $_SESSION['id_karyawan_rekap_pengajuan_upah']);
$stmt1->bindParam(2, $_SESSION['id_karyawan_rekap_pengajuan_upah']);
$stmt1->bindParam(3, $tgl_awal);
$stmt1->bindParam(4, $tgl_akhir);
$stmt1->bindParam(5, $_SESSION['status_rekap_pengajuan_upah']);
$stmt1->bindParam(6, $_SESSION['status_rekap_pengajuan_upah']);
$stmt1->execute();
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
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
    /* width: 100%; */
    border-collapse: collapse;
    margin-bottom: 10px;
  }

  table#content1 tr td:nth-child(n+2) {
    padding-left: 10px;
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
    <td align="center" style="font-weight: bold; padding-bottom: 20px; font-size: x-large;"><u>DATA REKAP PENGAJUAN UPAH</u></td>
  </tr>
</table>

<!-- content dibawah header -->
<table id="content1">
  <!-- <tr>
    <td width="20%">Nama Karyawan</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $row1['nama_pengirim'] ?></td>
    <td width="25%" align="right"></td>
  </tr> -->
  <tr>
    <td>Periode Rekap Pengajuan</td>
    <td align="center">:</td>
    <td align="left"><?= tanggal_indo($_SESSION['tgl_rekap_awal_pengajuan_upah']->format('Y-m-d')) . " sd " . tanggal_indo($_SESSION['tgl_rekap_akhir_pengajuan_upah']->format('Y-m-d')) ?></td>
    <td align="right"></td>
  </tr>
</table>
<!-- end content diatas header -->

<!-- content -->
<table id="content">
  <thead>
    <tr>
      <th>No.</th>
      <th>Tanggal Pengajuan</th>
      <th>No Pengajuan</th>
      <th>Nama Karyawan</th>
      <th>Nama Verifikator</th>
      <th>Tanggal Verifikasi</th>
      <th>Status</th>
      <th>Total Upah</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $no = 1;
    $total_upah_global = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $total_upah_global += $row['total_upah'];
    ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= tanggal_indo($row['tgl_pengajuan']) ?></td>
        <td><?= $row['no_pengajuan'] ?></td>
        <td><?= $row['nama_pengirim'] ?></td>
        <td>
          <?php
          if (empty($row['nama_verifikator'])) {
            echo "<div style='color: red;'>BELUM DIVERIFIKASI</div>";
          } else {
            echo $row['nama_verifikator'];
          }
          ?>

        </td>
        <td>
          <?php
          if (empty($row['tgl_verifikasi'])) {
            echo "<div style='color: red;'>BELUM DIVERIFIKASI</div>";
          } else {
            echo tanggal_indo($row['tgl_verifikasi']);
          }
          ?>
        </td>
        <td>
          <?php
          if ($row['terbayar'] == '1') {
            echo "<div style='color: red;'>Mengajukan</div>";
          } else if ($row['terbayar'] == '2') {
            echo "Terverifikasi";
          }
          ?>
        </td>
        <td style="text-align: right;"><?= 'Rp. ' . number_format($row['total_upah'], 0, ',', '.') ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr style="background-color: blanchedalmond">
      <td colspan="7" style="text-align: center; font-weight: bold;">TOTAL</td>
      <td style="text-align: right; font-weight: bold;"><?= 'Rp. ' . number_format($total_upah_global, 0, ',', '.') ?></td>
    </tr>
  </tfoot>
</table>

<!-- end content -->

<!-- summary -->
<!-- <style>
.bangsat {
  box-decoration-break: slice;
}
</style> -->

<table id="summary" autosize="1" style="page-break-inside: avoid;">
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
    <td align="center"><u><b><?= $_SESSION['nama']; ?></b></u></td>
  </tr>
</table>

<!-- end summary -->

<!-- footer -->
<!-- end footer -->

<?php
function tanggal_indo($date, $cetak_hari = false)
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
  $split = explode(' ', $date);
  $split_tanggal = explode('-', $split[0]);
  if (count($split) == 1) {
    $tgl_indo = $split_tanggal[2] . ' ' . $bulan[(int)$split_tanggal[1]] . ' ' . $split_tanggal[0];
  } else {
    $split_waktu = explode(':', $split[1]);
    $tgl_indo = $split_tanggal[2] . ' ' . $bulan[(int)$split_tanggal[1]] . ' ' . $split_tanggal[0] . ' ' . $split_waktu[0] . ':' . $split_waktu[1] . ':' . $split_waktu[2];
  }

  if ($cetak_hari) {
    $num = date('N', strtotime($date));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}
?>