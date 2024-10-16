<?php

include "svc/posts.php";

class Home_ctrl{

    private $posts_svc;

    public function __construct() {
        $this->posts_svc = new Posts_svc();
    }

    public function getPosts() {
        if (isset($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
            return $this->posts_svc->getPostsUser($userId);
        }
        return $this->posts_svc->getPosts();
    }

    public function getCategories($postId){
        return $this->posts_svc->getCategories($postId);
    }


    public function getAudiences($postId){
        return $this->posts_svc->getAudiences($postId);
    }


}

?>