<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "../svc/users.php";
include "../model/user.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_svc = new Users_svc();
    $user = $user_svc->validateLogin($username, $password);
    if ($user){
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['userid'] = $user->getUserId();
        $_SESSION['usertype'] = $user->getType();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    }
    //verificar si es admin redirigir a página de admin
    header('Location: /o_k_h/home');
    exit();
}
?>
