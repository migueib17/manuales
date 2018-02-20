<?php
function conectar(){

    $servername="localhost";
    $username="root";
    $password="";
    $dbname = "proyecto";

 $conexion = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conexion,"utf-8");
    return $conexion;
    mysqli_close($conexion);
  }
  function desconectar(){
    session_start();
    session_destroy();
    header("Location: index.php");
    exit;

  }


?>
