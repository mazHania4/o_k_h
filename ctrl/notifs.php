<?php

include "svc/posts.php";
include "svc/notifs.php";

class Notifs_ctrl {

    private $posts_svc;
    private $notif_svc;

    public function __construct() {
        $this->posts_svc = new Posts_svc();
        $this->notif_svc = new Notif_svc();
    }

    function getNotifs() {
        $userId = $_SESSION['userid'];
        return $this->notif_svc->getNotifications($userId);
    }

    function getPost($post_id) {
        return $this->posts_svc->getPost($post_id);
    }

    public function getCategories($postId){
        return $this->posts_svc->getCategories($postId);
    }


    public function getAudiences($postId){
        return $this->posts_svc->getAudiences($postId);
    }


}

?>