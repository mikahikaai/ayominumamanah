<?php
$database = new Database;
$db = $database->getConnection();
if (isset($_GET['id'])) {
  $deletesql = "UPDATE distribusi SET status='0', jam_datang=NULL, keterangan=NULL, tgl_validasi=NULL, validasi_oleh=NULL WHERE id=?";
  $stmt = $db->prepare($deletesql);
  $stmt->bindParam(1, $_GET['id']);

  if ($stmt->execute()) {
    $_SESSION['hasil_batal'] = true;
    $_SESSION['pesan'] = "Berhasil Menghapus Data";
  } else {
    $_SESSION['hasil_batal'] = false;
    $_SESSION['pesan'] = "Gagal Menghapus Data";
  }
}

if (isset($_GET['no_jalan'])) {
  $update_insentif = "UPDATE insentif SET bongkar=0, ontime=0, terbayar='0' WHERE no_perjalanan=?";
  $stmt_update_insentif = $db->prepare($update_insentif);
  $stmt_update_insentif->bindParam(1, $_GET['no_jalan']);
  $stmt_update_insentif->execute();

  $update_upah = "UPDATE upah SET upah='0', terbayar='0' WHERE no_perjalanan=?";
  $stmt_update_upah = $db->prepare($update_upah);
  $stmt_update_upah->bindParam(1, $_GET['no_jalan']);
  $stmt_update_upah->execute();

  $sukses = true;

  if ($sukses) {
    $_SESSION['hasil_batal'] = true;
    $_SESSION['pesan'] = "Berhasil Menghapus Data";
  } else {
    $_SESSION['hasil_batal'] = false;
    $_SESSION['pesan'] = "Gagal Menghapus Data";
  }
}
echo '<meta http-equiv="refresh" content="0;url=?page=distribusiread"/>';
