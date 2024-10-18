<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'model/user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ola Ke Hace?</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">
    <!-- CSS file -->
    <link href="/o_k_h/view/styles.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>
<body class="bg-secondary">
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark sidebar">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/o_k_h/home" class="d-flex align-items-center py-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <!--span class="fs-5 d-none d-sm-inline">Ola Ke Hace</span-->
                    <img style="width:240px; height:60px;" src="view/img/logo.png">
                </a>
                <ul class="flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"  style="list-style: none;" id="menu">
                    <li class="py-3">
                        <a href="/o_k_h/home" class="nav-link align-middle px-0">
                            <i class="fa-solid fa-house pe-3"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fa-solid fa-magnifying-glass pe-3"></i> <span class="ms-1 d-none d-sm-inline">Buscar</span>
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fa-regular fa-bell pe-3"></i> <span class="ms-1 d-none d-sm-inline">Notificaciones</span> 
                        </a>
                    </li>
                </ul>
                <hr style="background-color:white;height:2px;width:240px;">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="pb-4">
                        <a href="" class="d-flex fs-5 align-items-center text-white text-decoration-none">
                            <i class="fa-regular fa-circle-user user-icon"></i>
                            <span class="d-none d-sm-inline mx-1"><?php echo htmlspecialchars($_SESSION['username'])?></span>
                        </a>
                        <a class="nav-link fs-6" href="/o_k_h/ctrl/logout.php">Cerrar sesión</a>
                    </div>
                <?php else: ?>
                    <div class="pb-4">
                        <button id="openLogin" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col py-3">
            <!-- Mostrar mensaje de error de la sesión si existe -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <?php 
                $page = $_GET["pages"];
                if ($page == "home" ||$page == ""){
                    include "view/home.php";
                }
                if ($page == "search"){
                    include "view/search.php";
                }
                if ($page == "notifications"){
                    include "view/notifs.php";
                }
                if ($page == "logout"){
                    include "ctrl/logout_ctrl.php";
                }
                if ($page == "admin"){
                    //redirect instead of include?
                    include "view/admin.php";
                }
            ?>
        </div>
    </div>
</div>

<!-- Login Modal -->
<?php include 'view/visitant/log_in.php'?>
<?php include 'view/visitant/sing_in.php'?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>