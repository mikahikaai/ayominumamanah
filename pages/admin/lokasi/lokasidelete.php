<?php
$database = new Database;
$db = $database->getConnection();
    if(isset($_GET['id'])){
        $deletesql = "DELETE from lokasi where id=?"; 
        $stmt = $db->prepare($deletesql);
        $stmt->bindParam(1, $_GET['id']);

        if ($stmt->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Menambah Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Menambah Data";
        }
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=lokasiread"/>';

?>