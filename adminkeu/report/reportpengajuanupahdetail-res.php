<?php
session_start();
include "../../database/database.php";

$database = new Database;
$db = $database->getConnection();

if (isset($_GET['no_pengajuan'])) {
  $selectSql = "SELECT d.*, u.*, p.*, k.* FROM pengajuan_upah_borongan p
  INNER JOIN gaji u ON p.id_upah = u.id
  INNER JOIN distribusi d ON d.id = u.id_distribusi
  INNER JOIN karyawan k ON k.id = u.id_pengirim
  WHERE no_pengajuan=?";
  $stmt = $db->prepare($selectSql);
  $stmt->bindParam(1, $_GET['no_pengajuan']);
  $stmt->execute();
}
?>
<style>
  table#content {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    /* table-layout: fixed; */
    width: 100%;
  }

  table#content th {
    border: 1px solid grey;
    padding: 8px;
    text-align: center;
    width: fit-content;
    background-color: #DFDFDE;
  }

  table#content td {
    border: 1px solid grey;
    padding: 8px;
  }

  table#header {
    width: 100%;
    border: none;
    /* background-color: green; */
    margin-bottom: 10px;
    height: auto;
    border-collapse: collapse;
    /* table-layout: fixed; */
  }

  #logo-text {
    /* width: 100%; */
    /* float: left; */
    /* margin-left: 100px; */
    /* margin-top: 20px; */
    /* padding-top: 15px; */
    color: white;
    font-weight: bold;
    font-size: x-large;
    /* background-color: black; */
  }

  #logo-img {
    /* position: static; */
    /* float: right; */
    /* margin-right: 100px; */
    /* background-color: white; */
  }
</style>

<table id="header">
  <tr>
    <td></td>
    <td rowspan="3" align="center" width="15%"><img id="logo-img" src="../../images/logooo cropped resized compressed.png" height="75px" alt=""></td>
    <td></td>
    <!-- <td align="right" width="75%">
      <div id="logo-text">PT PANCURAN KAAPIT SENDANG</div>
    </td>
    <td align="left" width="25%"><img id="logo-img" src="../../images/logooo cropped resized compressed.png" width="75" alt=""></td> -->
  </tr>
  <tr>
    <td align="right" style="background-color: green; padding-right: 20px;" height="25%"><div id="logo-text">PT PANCURAN KAAPIT SENDANG</div></td>
    <!-- <td >4</td> -->
    <td style="background-color: green;"></td>
  </tr>
  <tr>
    <td></td>
    <!-- <td>6</td> -->
    <td></td>
  </tr>

</table>
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
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['no_perjalanan'] ?></td>
        <td><?= $row['nama'] ?></td>
        <td style="text-align: right;"><?= 'Rp. ' . number_format($row['upah'], 0, ',', '.') ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" style="text-align: center; font-weight: bold;">TOTAL</td>
      <td style="text-align: right; font-weight: bold;"><?= 'Rp. ' . number_format($total_upah, 0, ',', '.') ?></td>
    </tr>
  </tfoot>
</table>