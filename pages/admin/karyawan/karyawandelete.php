<?php
$database = new Database;
$db = $database->getConnection();
    if(isset($_GET['username'])){
        $deletesql = "DELETE from karyawan where username=?"; 
        $stmt = $db->prepare($deletesql);
        $stmt->bindParam(1, $_GET['username']);
    }
    if ($stmt->execute()){
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Menghapus Data";
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Menghapus Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=armadaread"/>';

?>