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
                AND p.state = 'active' ORDER BY p.post_id DESC LIMIT 15");
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

    function insertPost($post) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (publisher_id, title, start_date, start_time, end_date, end_time, capacity, location, description, url) VALUES (:p, :t, :sd, :st, :ed, :et, :c, :l, :d, :u)");
        $stmt->bindParam(':p', $post->getPublisherId(), PDO::PARAM_INT);
        $stmt->bindParam(':t', $post->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':sd', $post->getStart_date(), PDO::PARAM_STR);
        $stmt->bindParam(':st', $post->getStart_time(), PDO::PARAM_STR);
        $stmt->bindParam(':ed', $post->getEnd_date(), PDO::PARAM_STR);
        $stmt->bindParam(':et', $post->getEnd_time(), PDO::PARAM_STR);
        $stmt->bindParam(':c', $post->getCapacity(), PDO::PARAM_INT);
        $stmt->bindParam(':l', $post->getLocation(), PDO::PARAM_STR);
        $stmt->bindParam(':d', $post->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':u', $post->getUrl(), PDO::PARAM_STR);
        $stmt->execute();
        return true;        
    }

    public function searchPosts($searchTerm, $startDate, $endDate) {
        $query = "SELECT p.*, u.name AS publisher_name
                  FROM posts p 
                  JOIN users u ON p.publisher_id = u.user_id 
                  WHERE p.state = 'active'";

        if (!empty($searchTerm)) {
            $query .= " AND (p.title LIKE :searchTerm1
                        OR p.description LIKE :searchTerm2 
                        OR u.username LIKE :searchTerm3)";
        }
        if (!empty($startDate)) {
            $query .= " AND p.start_date >= :startDate";
        }
        if (!empty($endDate)) {
            $query .= " AND p.start_date <= :endDate";
        }

        $query .= " ORDER BY p.post_id DESC LIMIT 15";

        $stmt = $this->pdo->prepare($query);

        if (!empty($searchTerm)) {
            $searchTermWildcard = '%' . $searchTerm . '%';
            $stmt->bindParam(':searchTerm1', $searchTermWildcard, PDO::PARAM_STR);
            $stmt->bindParam(':searchTerm2', $searchTermWildcard, PDO::PARAM_STR);
            $stmt->bindParam(':searchTerm3', $searchTermWildcard, PDO::PARAM_STR);
        }
        if (!empty($startDate)) {
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        }
        if (!empty($endDate)) {
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Post"); 
    }
    
}

?>