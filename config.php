<?php 

// 1. Variables con accesos a la base de datos
$server="localhost";
$user="root";
$pass="root";
$db="Stock2";

// 2. Establecer conexión a la base de datos
$conexion = mysqli_connect($server, $user, $pass, $db);

// 3. Alerta de error en la conexión
if(!$conexion){
    die("<script>alert('Connection failed: ')</script>" . mysqli_connect_error());
}

?>