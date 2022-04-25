<?php

class Database
{
    private $host, $db_name, $username, $password;
    public $conn;

    function __construct()
    {
        // 1353

        // offline
        // $this->host = 'localhost';
        // $this->username = 'root';
        // $this->password = '';
        // $this->db_name = 'ayominumamanah';

        // online
        $this->host = 'srv158.niagahoster.com';
        $this->username = 'u1796449_rianseptiadi';
        $this->password = 'Rtbcvyfhgnpozx1!';
        $this->db_name = 'u1796449_ayominumamanah';
    }

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host .
                    ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Koneksi Error : " . $e->getMessage();
        }
        return $this->conn;
    }
}
