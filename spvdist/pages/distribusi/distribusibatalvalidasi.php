<?php
$database = new Database;
$db = $database->getConnection();
    if(isset($_GET['id'])){
        $deletesql = "UPDATE distribusi SET status='0', jam_datang=NULL, keterangan=NULL, tgl_validasi=NULL where id=?"; 
        $stmt = $db->prepare($deletesql);
        $stmt->bindParam(1, $_GET['id']);

        if ($stmt->execute()){
            $_SESSION['hasil_batal'] = true;
            $_SESSION['pesan'] = "Berhasil Menghapus Data";
        } else {
            $_SESSION['hasil_batal'] = false;
            $_SESSION['pesan'] = "Gagal Menghapus Data";
        }
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=distribusiread"/>';
