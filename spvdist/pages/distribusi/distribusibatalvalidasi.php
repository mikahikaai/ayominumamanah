<?php
$database = new Database;
$db = $database->getConnection();
if (isset($_GET['id'])) {
  $deletesql = "UPDATE distribusi SET status='0', jam_datang=NULL, keterangan=NULL, tgl_validasi=NULL, validasi_oleh=NULL WHERE id=?";
  $stmt = $db->prepare($deletesql);
  $stmt->bindParam(1, $_GET['id']);
  $stmt->execute();

  $update_gaji = "UPDATE gaji SET bongkar=0, ontime=0, upah=0 WHERE id_distribusi=?";
  $stmt_update_gaji = $db->prepare($update_gaji);
  $stmt_update_gaji->bindParam(1, $_GET['id']);
  $stmt_update_gaji->execute();

  $sukses = true;

  if ($sukses) {
    $_SESSION['hasil_batal'] = true;
    $_SESSION['pesan'] = "Berhasil Menghapus Data";
  } else {
    $_SESSION['hasil_batal'] = false;
    $_SESSION['pesan'] = "Gagal Menghapus Data";
  }
  echo '<meta http-equiv="refresh" content="0;url=?page=distribusiread"/>';
  exit;
}