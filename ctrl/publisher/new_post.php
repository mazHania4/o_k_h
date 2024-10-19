<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../svc/posts.php";
include "../../model/post.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_SESSION['username'])) {
        $userId = $_SESSION['userid'];

        $title = $_POST['title'];
        $startDate = $_POST['start_date'];
        $startTime = $_POST['start_time'];
        $endDate = $_POST['end_date'];
        $endTime = $_POST['end_time'];
        $capacity = $_POST['capacity'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $url = $_POST['url'];

        $post = new Post();
        $post->setTitle($title);
        $post->setStart_date($startDate);
        $post->setStart_time($startTime);
        $post->setEnd_date($endDate);
        $post->setEnd_time($endTime);
        $post->setCapacity($capacity);
        $post->setLocation($location);
        $post->setDescription($description);
        $post->setUrl($url);
        $post->setPublisherId($userId); 

        $postService = new Posts_svc();
        $result = $postService->insertPost($post);

        if ($result) {
            header("Location: /o_k_h/home"); 
        } else {
            echo "Error al crear la publicación.";
        }
    } else {
        echo "Debes iniciar sesión para crear una publicación.";
    }
}
?>
