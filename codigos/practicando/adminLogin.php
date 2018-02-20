<?php
session_start();

include('log.php');

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio sesión.</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <?php include 'inicioSesionMySQL.php';?>
    </head>
    <body>
                
        <div class="container-body">
            <div class='container-cabecera'>
                <?php include 'cabecera.php' ?>
            </div>

            <div class='container-cuerpo'>
                <div class='container-display'>
                    <div class="menu_login">
                         <?php  
        /*
         * Mostramos un formulario con dos inputs tipo texto para la introducción del nombre de usuario y contraseña
         */
        
        ?>
        
        <form  name="fcrearsesion" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  
            ?>" onsubmit="return comprobacionDatos()" method="post">

                    <p>Usuario:<input type="text" name="username"></p><p></p>
                    <p>Contraseña:<input type="password"  name="password"><p></p>

            <input type="submit" value="Iniciar sesión.">
            
        </form>
        <?php
        error_reporting(E_ERROR);
        /*
         * Una vez que se ha introducido el usuario y la contraseña en los inputs y tras habre pulsado Login
         */
        if (!empty($_POST['username'])  && !empty($_POST['password'])) { 

            $sql = "SELECT  username, password, type FROM usuarios WHERE username= \"" . $_POST["username"] ."\" AND password= \"" . md5($_POST["password"]) . "\";";

            $result = $GLOBALS['conn']->query($sql);
            if ($result->num_rows > 0) {
                $row=$result->fetch_assoc();
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["type"] = $row['type'];

                if($row['type']=='admin'){

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Sesion iniciada correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                    header("Location: agestionadministradores.php");
                }
                            elseif($row['type']=='profesor'){
                                
                                     //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Sesion iniciada correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                header("Location: pgestionproyectos.php");
                            }
                exit();
            }
            else {

                $sql = "SELECT username FROM usuarios  WHERE username= \"" . $_POST["username"] ."\";";
                $result = $GLOBALS['conn']->query($sql);
                if ($result->num_rows > 0) {
                     echo "<p> Contraseña incorrecta.</p><br>";
                }
                else{
                    echo "<p> Usuario inexistente.</p><br>";
                }   
            }
            $conn->close();
               }
        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>