<?php
session_start();
if (!isset($_SESSION['username'])) {
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
    <title>Modificar miembro.</title>
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
                                    <a href="agestionadministradores.php">Gestión de administradores</a>
                                    <a href="acrearmiembro.php">Dar de alta miembro</a>
                                    <a class="menu_lateral_selected" href="agestionmiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    <a class="menu_lateral_selected" href=amodificarmiembropropio.php>Modificar mis datos</a>
                                    ';

                                }
                                }  
                                ?> 
                            </ul>
                    </div> 

                </div>
        <div class='container-display'>
         <?php 
            /* Para poder modificar los datos o eliminar un miembro es necesario haber identificado 
             * al miembro en la pagina de agestionmiembros.php
             * Si ha ocurrido esto ha llegado una variable POST de nombre codDNI
             * 
             * Para eliminar un miembro se recibe una variable POST de nombre eliminarDNI
             * 
             * Si esta definida $codprofesor entonces es edicion de datos si esta difinida $codborrar entonces es borrado de datos 
             *              */
                $regex = "/^cod[A-Z0-9]*$/";
                $regex2 = "/^eliminar[A-Z0-9]*$/";
                $vars = array();

                foreach($_POST as $name=>$value){           
                    if(preg_match($regex, $name)) {
                        $cropped= str_replace('cod','',$name);
                        $codprofesor= $cropped;
                    }
                    if(preg_match($regex2, $name)) {
                        $cropped= str_replace('eliminar','',$name);
                        $codborrar= $cropped;
                    }
                }
                
                /*A amodificarmiembro.php se puede acceder a traves de "Gestion de miembros" en el menú lateral en el caso de que el usuario
                * logueado sea un admin o bien a traves de la opción "Editar mis datos" si el usuario logueado es un miembro. Si se accede a través
                * de la primera opción agestiónproferoes.php manda un mensaje tipo POST que identifica al miembro. En la segunda opción accedemos a
                * los datos del miembro a través de $_SESSION['username'].
                */                
                $codadmin=$_SESSION["username"];


                if(!isset($codprofesor) && !isset($codborrar) && !isset($_POST['nombre'])  && !isset($_POST['usuario'])){ 
                    //Si el usuario que accede es un miembro, y no se ha detectado entre los POST el patron de eliminación ni datos para actualizar sus datos
                    // significa que lo que va a hacer es editar sus propios  datos.
                    
                    $sql = "SELECT dni, nombre, username FROM usuarios WHERE ((type= \"profesor\") AND (username=\"" . $codadmin . "\")) ;";

                    $result = $conn->query($sql);
                    //$sql = "SELECT username FROM usuarios WHERE dni=\"" . $row['dni'] . "\" ;";
                    $row = $result->fetch_assoc(); 

                    $codprofesor=$_SESSION["username"];
                    
                    
                }
                
                if(isset($codprofesor)){ 
                
                    $sql = "SELECT dni, email, nombre, password, username FROM usuarios WHERE username=\"" . $codprofesor . "\" ;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); 
                        
                        /* Desplegamos una tabla con los datos del miembro de dni $codprofesor. Este código ha sido obtenido del mensaje POST
                         * que nos llega desde agestionmiembroes.php y que identifica al dni del miembro. 
                         * En caso de pulsar modificar los datos se reenviaran a la pagina mediante POST
                         *                          */
                        
                       echo '
                           <h1>Modificar datos de usuario del sistema:</h1>
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
                            <input type="hidden" name="codprofesor" value="' . $row['dni'] . '">                                                               
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
                            <input type="submit" value="Modificar datos miembro.">
            

                            <script>
                            function confirmDelete(){
                                var result = confirm("¿Está seguro de querer eliminar a este miembro?");
                                return result;
                            }
                            </script>
                            
                            </form>
                            <form  name="fborrarusuario" action="' .  htmlspecialchars($_SERVER['PHP_SELF']) . '"  method="post"  onsubmit="return confirmDelete()">
                            <input type="submit"  name="eliminar'. $codborrar . '" value="Eliminar miembro." id="bborrar">
                            </form>
                        ';      //Si se desea borrar al miembro se pulsa el botón "Eliminar" que manda un mensaje POST con el patrón "eliminar..."
                    }
            } elseif (!empty($_POST['nombre'])  && !empty($_POST['usuario']) && !empty($_POST['dni']) && 
                !is_null($_POST['contraseña']) && !empty($_POST['email'])){
                
                /*  Al entrar aqui es porque se ha pulsado Modificar en la tabla de datos editables antes comentada
                 *  y ahora actualizamos los nuevos datos del miembro  mostrando ahora una tabla con campos no editables
                 * Recibe variables POST que las utiliza para modificar los datos del miembro
                 *                  */
              
                if(empty($_POST['contraseña'])){ //Si la contraseña está vacia significa que no vamos a modificar la contraseña del administrador
                 
                    $sql = 'UPDATE usuarios SET nombre="' . $_POST['nombre'] . '", username="' . $_POST['usuario'] . '" , dni="' . $_POST['dni'] . '"'
                            . ', email="' . $_POST['email'] . '"WHERE dni="' . $_POST['codprofesor'] . '";';
                }
                else{//sin embargo si contiene algo significa que vamos a modificarla
                    $sql = 'UPDATE usuarios SET nombre="' . $_POST['nombre'] . '", username="' . $_POST['usuario'] . '" , dni="' . $_POST['dni'] . '"'
                            . ', password="' . md5($_POST['contraseña']) . '", email="' . $_POST['email'] . '"WHERE dni="' . $_POST['codprofesor'] . '";';
                }
                    if ($conn->query($sql) === FALSE) {

                        //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error en la actualización de los datos";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        echo "Error: en la actualización de datos por favor <a href=\"agestionmiembros.php\">vuelva a intentarlo<br>";
                        $conn->close();
                        exit();
                    } 
                     else{           //Datos modificados correctamente se muestran los datos tras su modificación
                        

                        //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Datos del miembro modificados correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo '
                            <h1>Datos del miembro modificados correctamente</h1>
                           <table>
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
                            exit();
     
            }if (isset($codborrar)){
                //Obtenemos el nombre de usuario del miembro cuyo dni es $codborrar para pdoer borrar las proyectoes que tiene creadas
                //Hemos obtenido $codborrar al encontrar un patrón entre los mensajes POST que indica que se ha pulsado el botón "Eliminar"
                $sql = "SELECT dni, username  FROM usuarios WHERE username= \"".$codadmin."\";"; 
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                
                $sql = "DELETE FROM usuarios WHERE username=\"" . $codadmin ."\" ";
                

                if ($conn->query($sql) === FALSE) {

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error en el borrado del miembro";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo "Error: en el borrado del miembro por favor  <a href=\"amodificarmiembros.php\">vuelva a intentarlo</a><br>";
                        exit();
                }
                else{

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Datos del miembro borrados correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                    echo "Borrado correcto del miembro.<a href=\"agestionmiembros.php\">Volver a gestión de miembros</a><br>";
                    if($_SESSION['type']=='profesor'){
                        header("Location: logout.php"); 
                        //Si el usuario que ha borrado a  un miembro es el propio miembro entonces sería incorrecto que este siguiera logueado en el 
                        //sistema tras borrarse a si mismo.
                    }
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
