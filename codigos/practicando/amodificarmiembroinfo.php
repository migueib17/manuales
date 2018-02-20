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
    <title>Modificar información.</title>
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
                                    <a href="acrearmiembro.php">Dar de alta usuario-miembro</a>
                                    <a href="agestionmiembros.php">Gestión de usuario-miembro</a>
                                    <a href="anadirmiembro.php">Añadir miembro</a>
                                    <a class="menu_lateral_selected" href="alistamiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    <a class="menu_lateral_selected" href=amodificarmiembro.php>Modificar mis datos</a>
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
             * Si ha ocurrido esto ha llegado una variable POST de codigo codtitulo
             * 
             * Para eliminar un miembro se recibe una variable POST de codigo eliminartitulo
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
                $codadmin=$_SESSION["email"];

 
                if(!isset($codprofesor) && !isset($codborrar) && !isset($_POST['email'])  && !isset($_POST['nombre'])){ 
                    //Si el usuario que accede es un miembro, y no se ha detectado entre los POST el patron de eliminación ni datos para actualizar sus datos
                    // significa que lo que va a hacer es editar sus propios  datos.
                    
                    $sql = "SELECT * FROM miembros WHERE ((id_miembro='$id_miembro') AND (email=\"" . $codadmin . "\"));";

                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc(); 

                    $codprofesor=$_SESSION["email"];


                }
                
                if(isset($codprofesor)){ 
                
                    $sql = "SELECT * FROM miembros WHERE email=\"" . $codprofesor . "\" ;";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); 
                     
                        


                        /* Desplegamos una tabla con los datos del miembro de titulo $codprofesor. Este código ha sido obtenido del mensaje POST
                         * que nos llega desde agestionmiembroes.php y que identifica al titulo del miembro. 
                         * En caso de pulsar modificar los datos se reenviaran a la pagina mediante POST
                         *                          */
                        
                       echo '
                           <h1>Modificar información de miembro:</h1>
                            <form  name="fmodificarusuario" action=" ' .  htmlspecialchars($_SERVER['PHP_SELF'])
                              . '" onsubmit="return comprobacionDatos(&quot;fmodificarusuario&quot;)" method="POST">
                            <table>
                            <tr>
                            <td>Nombre:</td>
                            <td><p><input type="text"   name="nombre" value="' . $row['nombre'] . '"></p><p id="nombre"></p></td>
                            
                            </tr>
                            <tr>
                            <td>Primer Apellido:</td>
                            <td><p><input type="text" name="primerApellido" value="' . $row['primerApellido'] . '"></p></p><p id="primerApellido"></p></td>                                                                               
                            </tr>
                            <tr>
                            <td>Segundo Apellido:</td>
                            <td><p><input type="text" name="segundoApellido" value="' . $row['segundoApellido'] . '"></p><p id="segundoApellido"></p></td>
                            </tr>
                            <tr>
                            <td>Categoría:</td>
                            <td><p><input type="text"  name="categoria" value="' . $row['categoria'] . '"></p><p id="categoria"></p></td>
                            </tr>
                            <tr>
                            <td>Director:</td>
                            <td><p><input type="text"  name="director" value="' . $row['director'] . '"></p><p id="director"></p></td>
                            </tr>
                            <tr>
                            <td>Email:</td>
                            <td><p><input type="text"  name="email" value="' . $row['email'] . '"></p><p id="email"></p></td>
                            <input type="hidden" name="codprofesor" value="' . $row['email'] . '">  
                            </tr>
                            <tr>
                            <td>Contraseña:</td>
                            <td><p>Si desea modificar la contraseña introduzca el nuevo valor:<input type="text"  name="password" value=""></p><p id="password"></p></td>
                            </tr> 
                            <tr>
                            <td>Teléfono:</td>
                            <td><p><input type="text"  name="telefono" value="' . $row['telefono'] . '"></p><p id="telefono"></p></td>
                            </tr>
                            <tr>
                            <td>Url:</td>
                            <td><p><input type="text"  name="url" value="' . $row['url'] . '"></p><p id="url"></p></td>
                            </tr>
                            <tr>
                            <td>Departamento:</td>
                            <td><p><input type="text"  name="departamento" value="' . $row['departamento'] . '"></p><p id="departamento"></p></td>
                            </tr>
                            <tr>
                            <td>Centro:</td>
                            <td><p><input type="text"  name="centro" value="' . $row['centro'] . '"></p><p id="centro"></p></td>
                            </tr> 
                            <tr>
                            <td>Institución:</td>
                            <td><p><input type="text"  name="institucion" value="' . $row['institucion'] . '"></p><p id="institucion"></p></td>
                            </tr>   
                            <tr>
                            <td>Dirección:</td>
                            <td><p><input type="text"  name="direccion" value="' . $row['direccion'] . '"></p><p id="direccion"></p></td>
                            </tr>
                            <tr>
                            <td>Activo:</td>
                            <td><p><input type="text"  name="activo" value="' . $row['activo'] . '"></p><p id="activo"></p></td>
                            </tr> 
                            <tr>
                            <td>Permiso:</td>
                            <td><p><input type="text"  name="permiso" value="' . $row['permiso'] . '"></p><p id="permiso"></p></td>
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

            } elseif (!empty($_POST['email'])) {
                

                /*  Al entrar aqui es porque se ha pulsado Modificar en la tabla de datos editables antes comentada
                 *  y ahora actualizamos los nuevos datos del miembro  mostrando ahora una tabla con campos no editables
                 * Recibe variables POST que las utiliza para modificar los datos del miembro
                 *                  */


                    $sql = 'UPDATE miembros SET nombre="' . $_POST['nombre'] . '", primerApellido="' . $_POST['primerApellido'] . '" , segundoApellido="' . $_POST['segundoApellido'] . '"'
                            . ', categoria="' . $_POST['categoria'] . '", director="' . $_POST['director'] . '", email="' . $_POST['email'] . '", telefono="'
                             . $_POST['telefono'] . '", url="' . $_POST['url'] . '", password="' . md5($_POST['password']) . '", departamento="' . $_POST['departamento'] . 
                             '", centro="' . $_POST['centro'] . '", institucion="' . $_POST['institucion'] . '", direccion="' . $_POST['direccion'] . '", activo="' . $_POST['activo'] . 
                             '", permiso="' . $_POST['permiso'] . '", foto="' . $_POST['foto'] . 
                             '"WHERE email="' . $_POST['codprofesor'] . '";';
                


                    if ($conn->query($sql) === FALSE) {

                        //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al modificar los datos";

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
                                <h1>Miembro correctamente modificado con los siguientes datos:</h1>
                                <table>
                               
                                <tr>
                                    <td>Nombre:</td>
                                    <td>' . $_POST['nombre'] .'</td>
                                </tr>
                                <tr>
                                    <td>Primer Apellido:</td>
                                    <td>' . $_POST['primerApellido'] .'</td>
                                </tr>
                                <tr>
                                    <td>Segundo Apellido:</td>
                                    <td>' . $_POST['segundoApellido'] .'</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>' . $_POST['email'] .'</td>
                                </tr>
                                <tr>
                                    <td>Teléfono:</td>
                                    <td>' . $_POST['telefono'] .'</td>
                                </tr>
                                <tr>
                                    <td>Centro:</td>
                                    <td>' . $_POST['centro'] .'</td>
                                </tr>
                                <tr>
                                    <td>Departamento:</td>
                                    <td>' . $_POST['departamento'] .'</td>
                                </tr>
                                <tr>
                                    <td>Categoría:</td>
                                    <td>' . $_POST['categoria'] .'</td>
                                </tr>
                                <tr>
                                    <td>Url:</td>
                                    <td>' . $_POST['url'] .'</td>
                                </tr>     
                                <tr>
                                    <td>Director:</td>
                                    <td>' . $_POST['director'] .'</td>
                                </tr>
                                <tr>
                                    <td>Dirección:</td>
                                    <td>' . $_POST['direccion'] .'</td>
                                </tr> 
                                <tr>
                                    <td>Activo:</td>
                                    <td>' . $_POST['activo'] .'</td>
                                </tr>                           
                                </table>
                                ';
                            }

                            exit();
     
            }


            if (isset($codborrar)){
                //Obtenemos el codigo de usuario del miembro cuyo titulo es $codborrar para pdoer borrar las miembroes que tiene creadas
                //Hemos obtenido $codborrar al encontrar un patrón entre los mensajes POST que indica que se ha pulsado el botón "Eliminar"
                $sql = "SELECT email, nombre  FROM miembros WHERE email= \"".$codadmin."\";"; 
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                
                $sql = "DELETE FROM miembros WHERE email=\"" . $codadmin ."\" ";
                

                if ($conn->query($sql) === FALSE) {

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error en el borrado del miembro";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo "Error: en el borrado del miembro por favor  <a href=\"pmodificarmiembroinfo.php\">vuelva a intentarlo</a><br>";
                        exit();
                }
                else{

                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Borrado correctamente en los datos del miembro";

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

    <div style="right: 0px; width: 404px; position: absolute; bottom: -650px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>
    </body>
</html>
