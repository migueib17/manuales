<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type']!='admin') {
    header("Location: adminlogin.php");
    die();
} 
include('log.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <html lang="en">
<head>
  <meta charset="utf-8">
  <title>Modificar administrador.</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script src="javascript/ejercicio/ejercicio.js"></script>    
    <?php    include 'inicioSesionMySQL.php'; ?>
</head>

 
    <body>
        <div class='container-cabecera'>
        <?php include 'cabecera.php' ?>
    </div>
    <div class='container-cuerpo'>
                <div class='container-menu'>
                    <div class="menu_lateral">
                            <ul>
                                <?php 

                                if(isset($_SESSION['username'])){
                                if($_SESSION['type']=='admin'){
                                    echo '
                                    <a href="acrearadministrador.php">Dar de alta administrador</a>
                                    <a class="menu_lateral_selected" href="agestionadministradores.php">Gestión de administradores</a>
                                    <a href="acrearmiembro.php">Dar de alta usuario-miembro</a>
                                    <a href="agestionmiembros.php">Gestión de usuario-miembro</a>
                                    <a href="anadirmiembro.php">Añadir miembro</a>
                                    <a href="alistamiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    ';

                                }
                                }   
                                ?> 
                            </ul>
                    </div> 
                </div>
        <div class='container-display'>
          <?php 
            /* Para poder modificar los datos o eliminar un administrador es necesario haber identificado 
             * al administrador en la pagina de agestionadministradores.php
             * Si ha ocurrido esto ha llegado una variable POST de nombre codDNI, esta variable POST es la que identifica al administrador a modificar
             * 
             * Para eliminar un administrador se recibe una variable POST de nombre eliminarDNI
             * 
             *              */
                $regex = "/^cod[A-Z0-9]*$/";
                $regex2 = "/^eliminar[A-Z0-9]*$/";
                $vars = array();


                foreach($_POST as $name=>$value){           
                    if(preg_match($regex, $name)) {
                        $cropped= str_replace('cod','',$name);
                        $codadmin= $cropped;

                
                      
                    }
                    if(preg_match($regex2, $name)) {
                        $cropped= str_replace('eliminar','',$name);
                        $codborrar= $cropped;

           

                    }
                }// Si esta definida $codadmin entonces es edicion de datos si esta definida $codborrar entonces es borrado de datos 
                
                $codadmin=$_SESSION["dni"];
                
                if(isset($codadmin)){ 
                    $sql = "SELECT dni, email, nombre, password, username FROM usuarios WHERE dni=\"" . $codadmin . "\" ;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); 
                        
                        /* Desplegamos una tabla con los datos del administrador de dni $codadmin contenidos en inputs
                         * en los cuales es posible editar los datos. Cuando se pulse el botón modificar los datos 
                         * serán reenviados a la propia página
                         *                          */
                        
                 



                       echo '
                           <h1>Modificar datos de administrador:</h1>
                            <form  name="fmodificarusuario" action=" ' .  htmlspecialchars($_SERVER['PHP_SELF'])
                              . '" onsubmit="return comprobacionDatos(&quot;fmodificarusuario&quot;)" method="POST">
                            <table>
                            <tr>
                            <td>Nombre y apellidos</td>
                            <td><p><input type="text"   name="nombre" value="' . $row['nombre'] . '"></p><p id="nombre"></p></td>
                            </tr>
                            <tr>
                            <td>DNI</td>
                            <td><p><input type="text" name="dni" value="' . $row['dni'] . '"></p></p><p id="dni"></p></td>
                            <input type="hidden" name="codadmin" value="' . $row['dni'] . '">                               
                            </tr>
                            <tr>
                            <td>Email</td>
                            <td><p><input type="text" name="email" value="' . $row['email'] . '"></p><p id="email"></p></td>
                            </tr>
                            <tr>
                            <td>Nombre usuario</td>
                            <td><p><input type="text"  name="usuario" value="' . $row['username'] . '"></p><p id="usuario"></p></td>
                            </tr>
                            <tr>
                            <td>Contaseña</td>
                            <td><p>Si desea modificar la contraseña introduzca el nuevo valor:<input type="text"  name="contraseña" value=""></p><p id="contraseña"></p></td>
                            </tr>                  
                            </table>
                            <input type="submit" value="Modificar datos de admistrador.">

                            <script>
                            function confirmDelete(){
                                var result = confirm("¿Está seguro de querer eliminar a este administrador?");
                                return result;
                            }
                            </script>
                            
                            </form>
                            <form  name="fborrarusuario" action="' .  htmlspecialchars($_SERVER['PHP_SELF']) . '"  method="post"  onsubmit="return confirmDelete()">
                            <input type="submit"  name="eliminar'. $codborrar . '" value="Eliminar administrador." id="bborrar">
                            </form>
                        ';
                
                    }
            

            } if (!empty($_POST['nombre'])  && !empty($_POST['usuario']) && !empty($_POST['dni']) && 
                !is_null($_POST['contraseña']) && !empty($_POST['email'])){
                
                /* Recibe variables POST que las utiliza para modificar los datos del admin.
                 * Al entrar aqui es porque se ha pulsado Modificar en la tabla de datos editables antes comentada
                 *  y ahora actualizamos los nuevos datos del administrador  mostrando una tabla con campos no editables
                 *                  */
              
                if(empty($_POST['contraseña'])){ //Si la contraseña está vacia significa que no vamos a modificar la contraseña del administrador
                 
                    $sql = 'UPDATE usuarios SET nombre="' . $_POST['nombre'] . '", username="' . $_POST['usuario'] . '" , dni="' . $_POST['dni'] . '"'
                            . ', email="' . $_POST['email'] . '"WHERE dni="' . $_POST['codadmin'] . '";';
                }
                else{//sin embargo si contiene algo significa que vamos a modificarla
                    $sql = 'UPDATE usuarios SET nombre="' . $_POST['nombre'] . '", username="' . $_POST['usuario'] . '" , dni="' . $_POST['dni'] . '"'
                            . ', password="' . md5($_POST['contraseña']) . '", email="' . $_POST['email'] . '"WHERE dni="' . $_POST['codadmin'] . '";';
                }
                    if ($conn->query($sql) === FALSE) {

                              //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion=" Error: en la actualización de datos";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        echo "Error: en la actualización de datos por favor vuelva a intentarlo <a href=\"agestionadministradores.php\">vuelva a intentarlo<br>";
                        $conn->close();
                        exit();
                    }
                    
                     else{  //Datos modificados correctamente se muestran los datos tras su modificación
                        

                         //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Datos del administrador modificados correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo '
                           <table>
                            <tr>
                                <td>Datos del administrador modificados correctamente</td>
                            <tr>
                                <td>Apellidos y nombre</td>
                                <td> ' . $_POST['nombre'] .'</td>
                            </tr>
                            <tr>
                                <td>DNI</td>
                                <td>' . $_POST['dni'] .'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>' . $_POST['email'] .'</td>
                            </tr>
                            <tr>
                                <td>Nombre usuario</td>
                                <td>' . $_POST['usuario'] .'</td>
                            <tr>
                                <td>Contaseña</td>
                                <td>' . $_POST['contraseña'] .'</td>
                            </tr>                  
                            </table>
                            '; 
                            }
                            $conn->close();
                            exit();

            }if (isset($codborrar)){ 
                /*
                 * Si se entra aqui es porque desde se ha pulsado el botón Eliminar administrador lo cual generá una variable POST que se se reenvia a esta página
                 * y que indica que vamos a eliminar al administrador para el cual se mostraban sus datos en campos modificables.
                 */
                
                //Obtenemos el nombre de usuario del administrador cuyo dni es $codborrar para pdoer borrar las proyectoes que tiene creadas
                

                $sql = "SELECT dni, username  FROM usuarios WHERE dni= \"".$codadmin."\";"; 
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                $sql = "DELETE FROM usuarios WHERE dni=\"" . $codadmin ."\" ";
                if ($conn->query($sql) === FALSE) {

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al borrar los datos";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        echo "Error: en el borrado del administrador por favor  <a href=\"amodificaradministradores.php\">vuelva a intentarlo</a><br>";
                        $conn->close();
                        exit();
                }
                else{
                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Borrado correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                            
                    echo "Borrado correcto del administrador.<a href=\"agestionadministradores.php\">Volver a gestión de administradores</a><br>";
                }  

                  

            }
            $conn->close();
        ?>
        </div>
    </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>
