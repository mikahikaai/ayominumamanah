<?php
session_start();
include "../../database/database.php";

$database = new Database;
$db = $database->getConnection();

if (isset($_GET['no_pengajuan'])) {
  $selectSql = "SELECT d.*, u.*, p.*, k1.nama nama_pengaju, k2.nama nama_verifikator FROM pengajuan_upah_borongan p
  RIGHT JOIN gaji u ON p.id_upah = u.id
  INNER JOIN distribusi d ON d.id = u.id_distribusi
  INNER JOIN karyawan k1 ON k1.id = u.id_pengirim
  INNER JOIN karyawan k2 ON k2.id = p.id_verifikator
  WHERE no_pengajuan=?";
  $stmt = $db->prepare($selectSql);
  $stmt->bindParam(1, $_GET['no_pengajuan']);
  $stmt->execute();

  $stmt1 = $db->prepare($selectSql);
  $stmt1->bindParam(1, $_GET['no_pengajuan']);
  $stmt1->execute();
  $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
}
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
    <td align="center" style="font-weight: bold; padding-bottom: 20px; font-size: x-large;"><u>DATA REKAP PENGAJUAN UPAH PER KARYAWAN</u></td>
  </tr>
</table>

<!-- content dibawah header -->
<table id="content1">
  <tr>
    <td width="20%">No Pengajuan</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $_GET['no_pengajuan'] ?></td>
    <td width="25%" align="right"><?= tanggal_indo($row1['tgl_pengajuan'], true); ?></td>
  </tr>
  <tr>
    <td width="20%">Nama Pengaju</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $row1['nama_pengaju'] ?></td>
    <td width="25%" align="right"></td>
  </tr>
  <tr>
    <td width="20%">Nama Verifikator</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= $row1['nama_verifikator'] ?></td>
    <td width="25%" align="right"></td>
  </tr>
  <tr>
    <td width="20%">Tanggal Verifikasi</td>
    <td width="5%" align="right">:</td>
    <td width="50%" align="left"><?= tanggal_indo($row1['tgl_verifikasi'], true) ?></td>
    <td width="25%" align="right"></td>
  </tr>
</table>
<!-- end content diatas header -->

<!-- content -->
<table id="content">
  <thead>
    <tr>
      <th>No.</th>
      <th>Tanggal & Jam Berangkat</th>
      <th>No Perjalanan</th>
      <th>Nama</th>
      <th>Upah</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $no = 1;
    $total_upah = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $total_upah += $row['upah'];
    ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= tanggal_indo($row['jam_berangkat']) ?></td>
        <td><?= $row['no_perjalanan'] ?></td>
        <td><?= $row['nama_pengaju'] ?></td>
        <td style="text-align: right;"><?= 'Rp. ' . number_format($row['upah'], 0, ',', '.') ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr style="background-color: blanchedalmond">
      <td colspan="4" style="text-align: center; font-weight: bold;">TOTAL</td>
      <td style="text-align: right; font-weight: bold;"><?= 'Rp. ' . number_format($total_upah, 0, ',', '.') ?></td>
    </tr>
  </tfoot>
</table>

<!-- end content -->

<!-- summary -->

<table id="summary" autosize="1" style="page-break-inside: avoid;">
  <tr>
    <td width="70%"></td>
    <td align="center">Banjarbaru, <?= tanggal_indo(date('Y-m-d')) ?></td>
  </tr>
  <tr>
    <td width=" 70%"></td>
    <td align="center"><img src="../../dist/verif/<?= $row1['qrcode'] . '.png' ?>" alt="" width="150px" height="150px"></td>
  </tr>
  <tr>
    <td width="70%"></td>
    <td align="center"><u><b><?= $row1['nama_verifikator']; ?></b></u></td>
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