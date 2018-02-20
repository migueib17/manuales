<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    die();
} 



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
    <title>Añadir proyecto</title>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="javascript/jquery/jquery-1.10.2.js"></script>
    <script src="javascript/jquery/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="javascript/ejercicio/ejercicio.js"></script> 
    <?php    include 'inicioSesionMySQL.php'; 
            include ('log.php');

    ?>




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
                                    <a class="menu_lateral_selected" href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a class="menu_lateral_selected" href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
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
        <h1>Crear proyecto:</h1>
            <?php
            /* Si recibe datos para crear proyecto lo crea y muestra mensaje de que todo esta correcto sino imprime el formulario para 
                crear el proyecto
             **/
            if (!empty($_POST['codigo'])  && !empty($_POST['titulo']) && !empty($_POST['descrpcion']) && 
                !empty($_POST['fechaInicio']) && !empty($_POST['fechaFin']) && !empty($_POST['entidadesColaboradoras'])
                 && !empty($_POST['cuantia']) && !empty($_POST['responsable']) && !empty($_POST['integrantes']) && !empty($_POST['url']) 
                ){

                    $sql = "SELECT COUNT(codigo) as existe FROM proyectosInvestigacion WHERE codigo =\"" . $_POST['codigo'] . "\" ;";
                    $sql2 = "SELECT COUNT(username)as existe2 FROM usuarios WHERE username =\"" . $_POST['usuario'] . "\" ;";
                    //Vemos si hay  proyectoes con el mismo DNI o nombre de usuario
                    $result = $conn->query($sql);
                    $result2= $conn->query($sql2);
                    if (($result->num_rows > 0) && ($result2->num_rows > 0)) {
                        
                        $row = $result->fetch_assoc();
                        $row2= $result2->fetch_assoc();
                        if( $row['existe'] == 0 ){                         
                        //Si no hay ya un proyecto con el mismo codigo insertamos datos
                            
                            $sql = "INSERT INTO proyectosInvestigacion (codigo, titulo, descrpcion, fechaInicio, fechaFin, entidadesColaboradoras, 
                                cuantia, responsable, integrantes, url)"
                            . " VALUES (\"" . $_POST['codigo'] . "\" , \"" . $_POST['titulo'] . "\" , \"" . $_POST['descrpcion'] . "\" , \"" . $_POST['fechaInicio'] . "\" , \"" 
                            . $_POST['fechaFin'] . "\" , \"" . $_POST['entidadesColaboradoras'] . "\" , \"" . $_POST['cuantia'] . "\" , \"" . $_POST['responsable'] . "\" , \""   
                            . $_POST['integrantes'] . "\" , \"" . $_POST['url'] . "\" )" ;
                


                            if ($conn->query($sql) === FALSE) {                 //Si se produce fallo al crear el proyecto que lo vuelva a intentar

                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la creación del proyecto";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                echo "Error: en la creación del proyecto por favor <a href=\"acrearproyecto.php\">vuelva a intentarlo<br>";
                                $conn->close();
                                exit();
                             }
                            else{//proyecto creado correctamente se muestran los datos con los cuales se ha creado el proyecto
                                
                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Proyecto correctamente creado";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);





                                echo '
                                <h1>Proyecto correctamente creado con los siguientes datos:</h1>
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
                            $conn->close();
                            exit();
                        }
                        else {
                            //Si existe un proyecto con el DNI o nombre de usuario introducidos.
                            if($row2['existe2'] == 0){
                                echo "Error proyecto coincide con otro que ya existe en el sistema. <a href=\"acrearproyecto.php\">Introduzca otro válido</a><br>";
                            }
                            else{
                                echo "Error proyecto coincide con otro que ya existe en el sistema  <a href=\"acrearproyecto.php\">introduce otro diferente</a><br>";
                            }

                            //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear el proyecto";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                        }
                }
            } 
        else{    /*Si no se han pasado datos por POST entonces significa que vamos a crear un nuevo proyector por tanto imprime la tabla
                  * con los inputs correspondientes para insertar los datos del proyecto  los cuales se reenviarán a esta misma página
                 * una vez que se pulse el boton de submit 
                 */
        

        ?>
        <form  name="fcrear" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" onsubmit=" return comprobacionDatos(&quot;fcrear&quot;)" method="POST">
                        <table>                
                <tr>
                    <td>Código:</td>
                    <td><p><input type="text" name="codigo"></p><p id="codigo"></p></td>
                </tr>
                <tr>
                    <td>Título:</td>
                    <td><p><input type="text" name="titulo"/></p></p><p id="titulo"></p></td>
                </tr>
                <tr>
                    <td>Descripción:</td>
                    <td><p><input type="text" name="descrpcion"/></p><p id="descrpcion"></p></td>
                </tr>
                <tr>
                    <td>Fecha de Inicio:</td>
                    <td><p><input type="date"  name="fechaInicio"></p><p id="fechaInicio"></p></td>
                </tr>
                <tr>
                    <td>Fecha de Fin:</td>
                    <td><p><input type="date"  name="fechaFin"></p><p id="fechaFin"></p></td>
                </tr>
                <tr>
                    <td>Entidades colaboradoras:</td>
                    <td><p><input type="text"  name="entidadesColaboradoras"><p id="entidadesColaboradoras"></p></td>
                </tr>
                <tr>
                    <td>Cuantía:</td>
                    <td><p><input type="text"  name="cuantia"><p id="cuantia"></p></td>
                </tr>
                <tr>
                    <td>Responsable:</td>
                    <td><p><input type="text"  name="responsable"><p id="responsable"></p></td>
                </tr>
                <tr>
                    <td>Integrantes:</td>
                    <td><p><input type="text"  name="integrantes"><p id="curso"></p></td>
                </tr>
                <tr>
                    <td>Url:</td>
                    <td><p><input type="text"  name="url"><p id="url"></p></td>
                </tr>                
                <tr>
                    <td>Nombre de usuario encargado del proyecto:</td>
                    <td><p><input type="text"  name="usuario" value='<?php echo $_SESSION['username'] ?>'><p id="usuario"></p></td>
                </tr>                 

                </table>
                <input type="submit" value="Dar de alta proyecto.">
                </form>
            <?php };
            
            $conn->close()?>
        </div>
    </div> 
    </body>

        
   
    <div style="right: 0px; width: 404px; position: absolute; bottom: -250px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>



</html>