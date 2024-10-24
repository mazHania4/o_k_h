<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include '../../svc/posts.php';
include '../../svc/notifs.php';
    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['approved']) && isset($_POST['post_id']) )
    $approved = $_POST['approved'];
    $post_id = $_POST['post_id'];
    $notifId = $_POST['not_id'];
    
    $postService = new Posts_svc();
    $notSvc = new Notif_svc();
    if ($approved == 'true') {
        $postService->approvePost($post_id);
    } else {
        $postService->disapprovePost($post_id);
    }
    $notSvc->dismiss($notifId);

    header('Location: /o_k_h/notifications');
    exit();

}

?>
