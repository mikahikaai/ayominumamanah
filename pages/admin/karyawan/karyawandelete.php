<?php
$database = new Database;
$db = $database->getConnection();
    if(isset($_GET['id'])){
        $deletesql1 = "DELETE from karyawan where id=?"; 
        $stmt1 = $db->prepare($deletesql1);
        $stmt1->bindParam(1, $_GET['id']);

        $deletesql2 = "DELETE from pengguna where id=?"; 
        $stmt2 = $db->prepare($deletesql2);
        $stmt2->bindParam(1, $_GET['id']);
    }
    if ($stmt1->execute() or $stmt2->execute()){
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Menghapus Data";
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Menghapus Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=karyawanread"/>';

?>