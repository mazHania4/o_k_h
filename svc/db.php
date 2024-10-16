<?php

class DB {

    private $host = 'localhost';
    private $dbname = 'o_k_h'; 
    private $user = 'udbs'; 
    private $pass = '4321'; 
    private $charset = 'utf8';
    private $socket = '/run/mysqld/mysqld.sock'; // Ruta al archivo del socket
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    public function getPDO(){
        $dsn = "mysql:host=127.0.0.1;port=3306;dbname=$this->dbname;charset=utf8"; // Data Source Name
        $pdo = null;
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass, $this->options);
        } catch (PDOException $e) {
            echo "Error de conexión a la base de datos: " . $e->getMessage();
            exit();
        }
        return $pdo;
    }

    public function getConn() {
        $conn = null;
        try {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname, null, $this->socket);
        } catch (Exception $e) {
            echo "Error de conexión a la base de datos: " . $e->getMessage();
            exit();
        }
        
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }        
        $conn->set_charset("utf8");
        return $conn;
    }
    
}

?>
