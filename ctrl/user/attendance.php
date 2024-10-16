<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../svc/users.php";

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_SESSION['username'])) {

        $postId = $_POST['post_id'];
        $user_id = $_SESSION['userid'];

        $user_svc = new Users_svc();
        $user = $user_svc->registerAttendance( $user_id, $postId);

        $attendances = $user_svc->getAttendances($postId)['attendances'];
        $data = [ 'success' => true, 'new_count' => $attendances ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
?>
