<?php

include_once 'db.php';

class Notif_svc{

    private $db;
    private $pdo;

    function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }

    public function getNotifications($userId) {
        $stmt = $this->pdo->prepare("SELECT n.*, nt.name AS type FROM notifications n 
            JOIN notif_types nt ON nt.notif_types_id=n.type_id
            JOIN posts p on p.post_id=n.post_id
            WHERE n.user_id=:u_id AND n.state='active'
            AND p.end_date > CURRENT_DATE");
        $stmt->bindParam(':u_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $not = $stmt->fetchAll(PDO::FETCH_CLASS, "Notification");     
        return $not;
    }

    public function dismiss($notifId) {
        $stmt = $this->pdo->prepare("UPDATE notifications SET state = 'dismissed' WHERE notification_id = :n_id");
        $stmt->bindParam(':n_id', $notifId, PDO::PARAM_INT);
        $stmt->execute();
    }

  
}

?>
