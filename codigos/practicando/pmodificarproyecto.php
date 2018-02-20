<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    die();
} 

include ('log.php');
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
    <title>Modificar proyecto.</title>
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
                                    <a class="menu_lateral_selected" href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a class="menu_lateral_selected" href=pgestionproyectos.php>Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    <a href=amodificarmiembropropio.php>Modificar mis datos</a>
                                    ';
                                }
                                }  
                                ?> 
                            </ul>
                    </div> 

                </div>
        <div class='container-display'>
         <?php 
            /* Para poder modificar los datos o eliminar un proyecto es necesario haber identificado 
             * al proyecto en la pagina de agestionproyectos.php
             * Si ha ocurrido esto ha llegado una variable POST de codigo codtitulo
             * 
             * Para eliminar un proyecto se recibe una variable POST de codigo eliminartitulo
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
                
                /*A amodificarproyecto.php se puede acceder a traves de "Gestion de proyectos" en el menú lateral en el caso de que el usuario
                * logueado sea un admin o bien a traves de la opción "Editar mis datos" si el usuario logueado es un proyecto. Si se accede a través
                * de la primera opción agestiónproferoes.php manda un mensaje tipo POST que identifica al proyecto. En la segunda opción accedemos a
                * los datos del proyecto a través de $_SESSION['username'].
                */                
                $codadmin=$_SESSION["codigo"];

                if(!isset($codprofesor) && !isset($codborrar) && !isset($_POST['titulo'])  && !isset($_POST['codigo'])){ 
                    //Si el usuario que accede es un proyecto, y no se ha detectado entre los POST el patron de eliminación ni datos para actualizar sus datos
                    // significa que lo que va a hacer es editar sus propios  datos.
                    
                    $sql = "SELECT * FROM proyectosInvestigacion WHERE ((id_proyecto='$id_proyecto') AND (codigo=\"" . $codadmin . "\")) ;";

                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc(); 

                    $codprofesor=$_SESSION["codigo"];

                }
                
                if(isset($codprofesor)){ 
                
                    $sql = "SELECT id_proyecto, codigo, titulo, descrpcion, fechaInicio, fechaFin, entidadesColaboradoras, cuantia, 
                    responsable, integrantes, url FROM proyectosInvestigacion WHERE codigo=\"" . $codprofesor . "\" ;";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); 
                        
                        /* Desplegamos una tabla con los datos del proyecto de titulo $codprofesor. Este código ha sido obtenido del mensaje POST
                         * que nos llega desde agestionproyectoes.php y que identifica al titulo del proyecto. 
                         * En caso de pulsar modificar los datos se reenviaran a la pagina mediante POST
                         *                          */
                        
                       echo '
                           <h1>Modificar proyecto:</h1>
                            <form  name="fmodificarusuario" action=" ' .  htmlspecialchars($_SERVER['PHP_SELF'])
                              . '" onsubmit="return comprobacionDatos(&quot;fmodificarusuario&quot;)" method="POST">
                            <table>
                            <tr>
                            <td>Código:</td>
                            <td><p><input type="text"   name="codigo" value="' . $row['codigo'] . '"></p><p id="codigo"></p></td>
                            <input type="hidden" name="codprofesor" value="' . $row['codigo'] . '">  
                            </tr>
                            <tr>
                            <td>Título:</td>
                            <td><p><input type="text" name="titulo" value="' . $row['titulo'] . '"></p></p><p id="titulo"></p></td>                                                                               
                            </tr>
                            <tr>
                            <td>Descripción:</td>
                            <td><p><input type="text" name="descrpcion" value="' . $row['descrpcion'] . '"></p><p id="descrpcion"></p></td>
                            </tr>
                            <tr>
                            <td>Fecha de Inicio:</td>
                            <td><p><input type="text"  name="fechaInicio" value="' . $row['fechaInicio'] . '"></p><p id="fechaInicio"></p></td>
                            </tr>
                            <tr>
                            <td>Fecha de Fin:</td>
                            <td><p><input type="text"  name="fechaFin" value="' . $row['fechaFin'] . '"></p><p id="fechaFin"></p></td>
                            </tr>
                            <tr>
                            <td>Entidades colaboradoras:</td>
                            <td><p><input type="text"  name="entidadesColaboradoras" value="' . $row['entidadesColaboradoras'] . '"></p><p id="entidadesColaboradoras"></p></td>
                            </tr>
                            <tr>
                            <td>Cuantía:</td>
                            <td><p><input type="text"  name="cuantia" value="' . $row['cuantia'] . '"></p><p id="cuantia"></p></td>
                            </tr>
                            <tr>
                            <td>Responsable:</td>
                            <td><p><input type="text"  name="responsable" value="' . $row['responsable'] . '"></p><p id="responsable"></p></td>
                            </tr>
                            <tr>
                            <td>Integrantes:</td>
                            <td><p><input type="text"  name="integrantes" value="' . $row['integrantes'] . '"></p><p id="integrantes"></p></td>
                            </tr>
                            <tr>
                            <td>Url:</td>
                            <td><p><input type="text"  name="url" value="' . $row['url'] . '"></p><p id="url"></p></td>
                            </tr>               
                            </table>
                            <input type="submit" value="Modificar datos proyecto.">
            

                            <script>
                            function confirmDelete(){
                                var result = confirm("¿Está seguro de querer eliminar a este proyecto?");
                                return result;
                            }
                            </script>
                            
                            </form>
                            <form  name="fborrarusuario" action="' .  htmlspecialchars($_SERVER['PHP_SELF']) . '"  method="post"  onsubmit="return confirmDelete()">
                            <input type="submit"  name="eliminar'. $codborrar . '" value="Eliminar proyecto." id="bborrar">
                            </form>
                        ';      //Si se desea borrar al proyecto se pulsa el botón "Eliminar" que manda un mensaje POST con el patrón "eliminar..."
                    }
            } if (!empty($_POST['codigo'])  && !empty($_POST['titulo'])  && !empty($_POST['descrpcion'])  && 
                !empty($_POST['fechaInicio'])  && !empty($_POST['fechaFin'])  && !empty($_POST['entidadesColaboradoras'])  
                && !empty($_POST['cuantia']) && !empty($_POST['responsable']) && !is_null($_POST['integrantes']) && !empty($_POST['url'])){
                
                /*  Al entrar aqui es porque se ha pulsado Modificar en la tabla de datos editables antes comentada
                 *  y ahora actualizamos los nuevos datos del proyecto  mostrando ahora una tabla con campos no editables
                 * Recibe variables POST que las utiliza para modificar los datos del proyecto
                 *                  */
                    $sql = 'UPDATE proyectosInvestigacion SET codigo="' . $_POST['codigo'] . '", titulo="' . $_POST['titulo'] . '" , descrpcion="' . $_POST['descrpcion'] . '"'
                            . ', fechaInicio="' . $_POST['fechaInicio'] . '", fechaFin="' . $_POST['fechaFin'] . '", entidadesColaboradoras="' . $_POST['entidadesColaboradoras'] . '", cuantia="'
                             . $_POST['cuantia'] . '", responsable="' . $_POST['responsable'] . '", integrantes="' . $_POST['integrantes'] . '", url="' . $_POST['url'] . 
                             '"WHERE codigo="' . $_POST['codprofesor'] . '";';
                


                    if ($conn->query($sql) === FALSE) {

                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la modificación del proyecto";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo "Error: en la actualización de datos por favor <a href=\"pgestionproyectos.php\">vuelva a intentarlo<br>";
                        $conn->close();
                        exit();
                    } 
                     else{           //Datos modificados correctamente se muestran los datos tras su modificación
                        
                        //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Proyecto creado correctamente modificado";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);




                        echo '
                                <h1>Proyecto correctamente modificado con los siguientes datos:</h1>
                                <table>
                                <tr>
                                    <td>Código:</td>
                                    <td> ' . $_POST['codigo'] .'</td>
                                </tr>
                                <tr>
                                    <td>Título:</td>
                                    <td>' . $_POST['titulo'] .'</td>
                                </tr>
                                <tr>
                                    <td>Descripción:</td>
                                    <td>' . $_POST['descrpcion'] .'</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Inicio:</td>
                                    <td>' . $_POST['fechaInicio'] .'</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Fin:</td>
                                    <td>' . $_POST['fechaFin'] .'</td>
                                </tr>
                                <tr>
                                    <td>Entidades colaboradoras:</td>
                                    <td>' . $_POST['entidadesColaboradoras'] .'</td>
                                </tr>
                                <tr>
                                    <td>Cuantía:</td>
                                    <td>' . $_POST['cuantia'] .'</td>
                                </tr>
                                <tr>
                                    <td>Responsable:</td>
                                    <td>' . $_POST['responsable'] .'</td>
                                </tr>
                                <tr>
                                    <td>Integrantes:</td>
                                    <td>' . $_POST['integrantes'] .'</td>
                                </tr>
                                <tr>
                                    <td>Url:</td>
                                    <td>' . $_POST['url'] .'</td>
                                </tr>                        
                                </table>
                                ';
                            }
                            exit();
     
            }if (isset($codborrar)){
                //Obtenemos el codigo de usuario del proyecto cuyo titulo es $codborrar para pdoer borrar las proyectoes que tiene creadas
                //Hemos obtenido $codborrar al encontrar un patrón entre los mensajes POST que indica que se ha pulsado el botón "Eliminar"
                $sql = "SELECT codigo, titulo  FROM proyectosInvestigacion WHERE codigo= \"".$codadmin."\";"; 
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                
                $sql = "DELETE FROM proyectosInvestigacion WHERE codigo=\"" . $codadmin ."\" ";
                

                if ($conn->query($sql) === FALSE) {
                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en el borrado del proyecto";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                        echo "Error: en el borrado del proyecto por favor  <a href=\"pmodificarproyecto.php\">vuelva a intentarlo</a><br>";
                        exit();
                }
                else{
                    
                            //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Borrado correcto del proyecto";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                    echo "Borrado correcto del proyecto.<a href=\"pgestionproyectos.php\">Volver a gestión de proyectos</a><br>";
                    if($_SESSION['type']=='profesor'){
                        header("Location: logout.php"); 
                        //Si el usuario que ha borrado a  un proyecto es el propio proyecto entonces sería incorrecto que este siguiera logueado en el 
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
