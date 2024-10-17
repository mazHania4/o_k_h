<?php

include "svc/posts.php";
include "svc/reports.php";

class Home_ctrl{

    private $posts_svc;
    private $reports_svc;

    public function __construct() {
        $this->posts_svc = new Posts_svc();
        $this->reports_svc = new Reports_svc();
    }

    public function getPosts() {
        if (isset($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
            return $this->posts_svc->getPostsUser($userId);
        }
        return $this->posts_svc->getPosts();
    }

    public function getReportTypes() {
        return $this->reports_svc->getReportTypes();;
    }

    public function getCategories($postId){
        return $this->posts_svc->getCategories($postId);
    }


    public function getAudiences($postId){
        return $this->posts_svc->getAudiences($postId);
    }


}

?>