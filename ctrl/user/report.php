<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../svc/reports.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_SESSION['username'])) {

        $postId = $_POST['post_id'];
        $motiveId = $_POST['motive'];
        $comment = $_POST['comment'];
        $user_id = $_SESSION['userid'];

        $reports_svc = new Reports_svc();
        $reports_svc->registerReport($user_id, $postId, $motiveId, $comment);

        $data = [ 'success' => true , 'postid' => $postId, 'motive' => $motiveId, 'user'=>$user_id];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
?>
