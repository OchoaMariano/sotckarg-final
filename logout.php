<?php 

// Iniciamos la sesión
session_start();

// Limpimos todas las variables de sesión
$_SESSION = array();

// Finalmente destruimos la sesión
session_destroy();

// Redirigimos al usuario a la página de inicio
header("Location: index.php");

?>