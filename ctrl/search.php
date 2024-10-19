<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include "../model/post.php";
include "../svc/posts.php"; 
    

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // Recibe los parámetros de búsqueda del formulario
    $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
    $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
    $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';
    
    // Llama al servicio para realizar la búsqueda
    $postService = new Posts_svc();
    $results = $postService->searchPosts($searchTerm, $startDate, $endDate);
    
    $_SESSION['searched_posts'] = serialize($results);

    header('Location: /o_k_h/search');
    exit();

}

?>
