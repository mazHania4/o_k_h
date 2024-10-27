<?php

include_once 'db.php';

class Users_svc{

    private $db;
    private $pdo;

    function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }

    public function registerAttendance($userId, $postId){
        $stmt = $this->pdo->prepare("INSERT INTO attendances (user_id, post_id) VALUES (:u_id, :p_id)");
        $stmt->bindParam(':u_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':p_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
    }

    function getAttendances($postId){
        $sqlCount = "SELECT attendances FROM posts WHERE post_id = :post_id";
        $stmtCount = $this->pdo->prepare($sqlCount);
        $stmtCount->execute(['post_id' => $postId]);
        return $stmtCount->fetch();
    }

    public function validateLogin($username, $password){
        try{
            $hash = hash('sha256', $password); 
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password AND state = 'active'");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetchObject("User");
            return $user;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function createUser($name, $username, $email, $password){
        try {
            $hash = hash('sha256', $password); 
            $stmt = $this->pdo->prepare("INSERT INTO users (name, username, email, password) VALUES (:n, :u, :e, :p)");
            $stmt->bindParam(':n', $name, PDO::PARAM_STR);
            $stmt->bindParam(':u', $username, PDO::PARAM_STR);
            $stmt->bindParam(':e', $email, PDO::PARAM_STR);
            $stmt->bindParam(':p', $hash, PDO::PARAM_STR);
            $stmt->execute();
            $user = $this->validateLogin($username, $password);
            return $user;
        } catch (PDOException $e) {
            return null;
        }
    }

    function becomePublisher($userid) {
        $stmt = $this->pdo->prepare("INSERT INTO publishers (user_id) VALUES (:u_id)");
        $stmt->bindParam(':u_id', $userid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

}

?>