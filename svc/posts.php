<?php

include 'db.php';

class Posts_svc{

    private $db;
    private $pdo;

    function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }

    public function getPosts(){
        $stmt = $this->pdo->prepare("SELECT * FROM getPosts");
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, "Post");     
        return $posts;
    }

    public function getPostsUser($user_id){
        $stmt = $this->pdo->prepare("SELECT p.*, u.name AS publisher_name FROM posts p
                JOIN users u ON p.publisher_id = u.user_id WHERE p.post_id NOT IN 
                    ( SELECT a.post_id FROM attendances a WHERE a.user_id = :u_id )
                ORDER BY p.post_id DESC LIMIT 15");
        $stmt->bindParam(':u_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, "Post");     
        return $posts;
    }

    public function getCategories($postId){
        $stmt = $this->pdo->prepare("SELECT c.name FROM categories c JOIN post_cat pc ON pc.category_id = c.category_id JOIN posts p ON p.post_id = pc.post_id WHERE p.post_id = :p_id");
        $stmt->execute(['p_id' => $postId]);
        $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);     
        return $cats;
    }

    public function getAudiences($postId){
        $stmt = $this->pdo->prepare("SELECT a.name FROM audience_types a JOIN post_audience pa ON pa.audience_type_id = a.audience_type_id JOIN posts p ON p.post_id = pa.post_id WHERE p.post_id = :p_id");
        $stmt->execute(['p_id' => $postId]);
        $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);     
        return $cats;
    }

}

?>