<?php
session_start();
session_unset(); // Borrar todas las variables de sesión
session_destroy(); // Destruir la sesión
header('Location: /o_k_h/home');
exit();
?>
