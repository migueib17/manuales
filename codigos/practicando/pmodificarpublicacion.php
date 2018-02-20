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
    <title>Modificar publicación.</title>
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
                                    <a href="alistamiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a class="menu_lateral_selected" href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a class="menu_lateral_selected" href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    <a href=amodificarmiembro.php>Modificar mis datos</a>
                                    ';
                                }
                                }  
                                ?> 
                            </ul>
                    </div> 

                </div>
        <div class='container-display'>
         <?php 
            /* Para poder modificar los datos o eliminar un publicacion es necesario haber identificado 
             * al publicacion en la pagina de agestionpublicaciones.php
             * Si ha ocurrido esto ha llegado una variable POST de codigo codtitulo
             * 
             * Para eliminar un publicacion se recibe una variable POST de codigo eliminartitulo
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
                
                /*A amodificarpublicacion.php se puede acceder a traves de "Gestion de publicacions" en el menú lateral en el caso de que el usuario
                * logueado sea un admin o bien a traves de la opción "Editar mis datos" si el usuario logueado es un publicacion. Si se accede a través
                * de la primera opción agestiónproferoes.php manda un mensaje tipo POST que identifica al publicacion. En la segunda opción accedemos a
                * los datos del publicacion a través de $_SESSION['username'].
                */                
                $codadmin=$_SESSION["doi"];

                if(!isset($codprofesor) && !isset($codborrar) && !isset($_POST['titulo'])  && !isset($_POST['doi'])){ 
                    //Si el usuario que accede es un publicacion, y no se ha detectado entre los POST el patron de eliminación ni datos para actualizar sus datos
                    // significa que lo que va a hacer es editar sus propios  datos.
                    
                    $sql = "SELECT * FROM publicaciones WHERE ((id_proyecto='$id_proyecto') AND (doi=\"" . $codadmin . "\")) ;";

                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc(); 

                    $codprofesor=$_SESSION["doi"];

                }
                
                if(isset($codprofesor)){ 
                
                    $sql = "SELECT * FROM publicaciones WHERE doi=\"" . $codprofesor . "\" ;";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); 
                        
                        /* Desplegamos una tabla con los datos del publicacion de titulo $codprofesor. Este código ha sido obtenido del mensaje POST
                         * que nos llega desde agestionpublicaciones.php y que identifica al titulo del publicacion. 
                         * En caso de pulsar modificar los datos se reenviaran a la pagina mediante POST
                         *                          */
                        
                       echo '
                           <h1>Modificar publicaciones:</h1>
                            <form  name="fmodificarusuario" action=" ' .  htmlspecialchars($_SERVER['PHP_SELF'])
                              . '" onsubmit="return comprobacionDatos(&quot;fmodificarusuario&quot;)" method="POST">
                            <table>
                            <tr>
                            <td>Tipo:</td>
                            <td><p><input type="text"   name="tipo" value="' . $row['tipo'] . '"></p><p id="tipo"></p></td>
                            
                            </tr>
                            <tr>
                            <td>ID proyecto:</td>
                            <td><p><input type="text" name="id_proyec" value="' . $row['id_proyec'] . '"></p><p id="id_proyec"></p></td>
                            </tr>
                            <tr>
                            <td>DOI:</td>
                            <td><p><input type="text" name="doi" value="' . $row['doi'] . '"></p></p><p id="doi"></p></td>  
                            <input type="hidden" name="codprofesor" value="' . $row['doi'] . '">                                                                               
                            </tr>
                            <tr>
                            <td>Título:</td>
                            <td><p><input type="text" name="titulo" value="' . $row['titulo'] . '"></p><p id="titulo"></p></td>
                            </tr>
                            <tr>
                            <td>Autores:</td>
                            <td><p><input type="text"  name="autores" value="' . $row['autores'] . '"></p><p id="autores"></p></td>
                            </tr>
                            <tr>
                            <td>Fecha de Publicación:</td>
                            <td><p><input type="date"  name="fechaPublicacion" value="' . $row['fechaPublicacion'] . '"></p><p id="fechaPublicacion"></p></td>
                            </tr>
                            <tr>
                            <td>Resumen:</td>
                            <td><p><input type="text"  name="resumen" value="' . $row['resumen'] . '"></p><p id="resumen"></p></td>
                            </tr>
                            <tr>
                            <td>Palabras clave:</td>
                            <td><p><input type="text"  name="palabras" value="' . $row['palabras'] . '"></p><p id="palabras"></p></td>
                            </tr>
                            <tr>
                            <td>Url:</td>
                            <td><p><input type="text"  name="url" value="' . $row['url'] . '"></p><p id="url"></p></td>
                            </tr>
                            
                            </table>
                            <input type="submit" value="Modificar datos publicación.">
            

                            <script>
                            function confirmDelete(){
                                var result = confirm("¿Está seguro de querer eliminar a este publicación?");
                                return result;
                            }
                            </script>
                            
                            </form>
                            <form  name="fborrarusuario" action="' .  htmlspecialchars($_SERVER['PHP_SELF']) . '"  method="post"  onsubmit="return confirmDelete()">
                            <input type="submit"  name="eliminar'. $codborrar . '" value="Eliminar publicación." id="bborrar">
                            </form>
                        ';      //Si se desea borrar al publicación se pulsa el botón "Eliminar" que manda un mensaje POST con el patrón "eliminar..."
                    }
            } if (!empty($_POST['tipo'])  && !empty($_POST['id_proyec'])  && !empty($_POST['doi'])  && 
                !empty($_POST['titulo'])  && !empty($_POST['autores'])  && !empty($_POST['fechaPublicacion'])  
                && !empty($_POST['resumen']) && !empty($_POST['palabras']) && !empty($_POST['url'])){
                
                /*  Al entrar aqui es porque se ha pulsado Modificar en la tabla de datos editables antes comentada
                 *  y ahora actualizamos los nuevos datos del publicación  mostrando ahora una tabla con campos no editables
                 * Recibe variables POST que las utiliza para modificar los datos del publicación
                 *                  */
                    $sql = 'UPDATE publicaciones SET tipo="' . $_POST['tipo'] . '", id_proyec="' . $_POST['id_proyec'] . '", titulo="' . $_POST['titulo'] . '", autores="' . $_POST['autores'] . '", fechaPublicacion="' . $_POST['fechaPublicacion'] . '", resumen="'
                             . $_POST['resumen'] . '", palabras="' . $_POST['palabras'] . '", url="' . $_POST['url'] . 
                             '"WHERE doi="' . $_POST['codprofesor'] . '";';
                


                    if ($conn->query($sql) === FALSE) {
                         //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al modificar la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        echo "Error: en la actualización de datos por favor <a href=\"pgestionpublicaciones.php\">vuelva a intentarlo<br>";
                        $conn->close();
                        exit();
                    } 
                     else{           //Datos modificados correctamente se muestran los datos tras su modificación
                        

                           //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Éxito al modificar la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo '
                                <h1>Publicación correctamente modificada con los siguientes datos:</h1>
                                <table>
                                                    <tr>
                                                        <td>ID publicacion:</td>
                                                        <td>' . $_POST['id_publicacion'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID proyecto:</td>
                                                        <td>' . $_POST['id_proyec'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tipo:</td>
                                                        <td> ' . $_POST['tipo'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>DOI:</td>
                                                        <td>' . $_POST['doi'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Título:</td>
                                                        <td>' . $_POST['titulo'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Autores:</td>
                                                        <td>' . $_POST['autores'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fecha de Publicación:</td>
                                                        <td>' . $_POST['fechaPublicacion'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Resumen:</td>
                                                        <td>' . $_POST['resumen'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Palabras:</td>
                                                        <td>' . $_POST['palabras'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Url:</td>
                                                        <td>' . $_POST['url'] .'</td>
                                                    </tr>
                                                 
                                                
                                                    
                                                                              
                                                    </table>
                                ';
                            }


                    }

                        else{

                            echo "Por favor rellene todos los campos</a><br>";
                        exit();

                    }
                    

     
            if (isset($codborrar)){
                //Obtenemos el codigo de usuario del publicacion cuyo titulo es $codborrar para pdoer borrar las publicaciones que tiene creadas
                //Hemos obtenido $codborrar al encontrar un patrón entre los mensajes POST que indica que se ha pulsado el botón "Eliminar"
                $sql = "SELECT codigo, titulo  FROM publicaciones WHERE doi= \"".$codadmin."\";"; 
                $result = $conn->query($sql);
               

                
                $sql = "DELETE FROM publicaciones WHERE doi=\"" . $codadmin ."\" ";
                

                if ($conn->query($sql) === FALSE) {
                       //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al borrar la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        echo "Error: en el borrado de la publicación por favor  <a href=\"pmodificarpublicacion.php\">vuelva a intentarlo</a><br>";
                        exit();
                }
                else{

                       //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Borrado correcto de la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                    echo "Borrado correcto de la publicación.<a href=\"pgestionpublicaciones.php\">Volver a gestión de publicaciones</a><br>";
                    if($_SESSION['type']=='profesor'){
                        header("Location: logout.php"); 
                        //Si el usuario que ha borrado a  un publicacion es el propio publicacion entonces sería incorrecto que este siguiera logueado en el 
                        //sistema tras borrarse a si mismo.
                    }
                }
                


            }



            $conn->close();
        ?>
        </div>
    </div>

    <div style="right: 0px; width: 404px; position: absolute; bottom: -250px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>
    </body>
</html>
