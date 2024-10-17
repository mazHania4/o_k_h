<?php

include_once 'db.php';

class Reports_svc{

    private $db;
    private $pdo;

    function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }

    public function getReportTypes(){
        $stmt = $this->pdo->prepare("SELECT name, report_types_id AS id FROM report_types");
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);    
        return $types;
    }

    public function registerReport($user_id, $postId, $motiveId, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reports(user_id, post_id, report_type, comment) VALUES (:u_id, :p_id, :r_type, :comm)");
        
        $stmt->bindParam(':u_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':p_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':r_type', $motiveId, PDO::PARAM_INT);
        $stmt->bindParam(':comm', $comment, PDO::PARAM_STR);
        $stmt->execute();
    }

}

?>