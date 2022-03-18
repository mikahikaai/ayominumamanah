<?php
$database = new Database;
$db = $database->getConnection();
    if(isset($_GET['id'])){
        $deletesql = "DELETE from bagian where id=?"; 
        $stmt = $db->prepare($deletesql);
        $stmt->bindParam(1, $_GET['id']);
    }
    if ($stmt->execute()){
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Menghapus Data";
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Menghapus Data";
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=bagianread"/>';

?>