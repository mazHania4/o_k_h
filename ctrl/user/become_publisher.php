<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "../../svc/users.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    $user_svc = new Users_svc();
    $user = $user_svc->becomePublisher($userid);
    if ($user){
        $_SESSION['usertype'] = 'publisher';
    } else {
        $_SESSION['error'] = "El usuario no pudo ascender de categoría";
    }
    header('Location: /o_k_h/home');
    exit();
}

?>
