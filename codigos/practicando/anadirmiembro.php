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
    <title>Añadir miembro</title>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="javascript/jquery/jquery-1.10.2.js"></script>
    <script src="javascript/jquery/jquery-ui.js"></script>
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
                                    <a class="menu_lateral_selected" href="anadirmiembro.php">Añadir miembro</a>
                                    <a href="alistamiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a class="menu_lateral_selected" href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    <a href=amodificarmiembropropio.php>Modificar mis datos</a>
                                    ';
                                }
                                }
                                ?> 
                            </ul>
                    </div> 

                </div>
        <div class='container-display'>
        <h1>Crear miembro:</h1>
            <?php
            /* Si recibe datos para crear miembro lo crea y muestra mensaje de que todo esta correcto sino imprime el formulario para 
                crear el miembro
             **/
            if (!empty($_POST['nombre'])){

                    $sql = "SELECT COUNT(email) as existe FROM miembros WHERE email =\"" . $_POST['email'] . "\" ;";
                    $sql2 = "SELECT COUNT(telefono)as existe2 FROM miembros WHERE telefono =\"" . $_POST['telefono'] . "\" ;";
                    //Vemos si hay  miembroes con el mismo DNI o nombre de usuario
                    $result = $conn->query($sql);
                    $result2= $conn->query($sql2);
                    if (($result->num_rows > 0) && ($result2->num_rows > 0)) {
                        
                        $row = $result->fetch_assoc();
                        $row2= $result2->fetch_assoc();
                        if( $row['existe'] == 0 ){                         
                        //Si no hay ya un miembro con el mismo codigo insertamos datos
                            
                            $sql = "INSERT INTO miembros (nombre, primerApellido, segundoApellido, categoria, director, email, 
                                password, telefono, departamento, url, centro, institucion, direccion, activo, permiso)"
                            . " VALUES (\"" . $_POST['nombre'] . "\" , \"" . $_POST['primerApellido'] . "\" , \"" . $_POST['segundoApellido'] . "\" , \"" . $_POST['categoria'] . "\" , \"" 
                            . $_POST['director'] . "\" , \"" . $_POST['email'] . "\" , \"" . $_POST['password'] . "\" , \"" . $_POST['telefono'] . "\" , \""   
                            . $_POST['departamento'] . "\" , \"" . $_POST['url'] . "\" , \"" . $_POST['institucion'] . "\" , \"" . $_POST['centro'] . "\"
                             , \"" . $_POST['direccion'] . "\" , \"" . $_POST['activo'] . "\" , \"" . $_POST['permiso'] . "\" )" ;
                    
                            if ($conn->query($sql) === FALSE) {                 //Si se produce fallo al crear el miembro que lo vuelva a intentar

                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear el miembro";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                echo "Error: en la creación del miembro por favor <a href=\"anadirmiembro.php\">vuelva a intentarlo<br>";
                                $conn->close();
                                exit();
                             }
                            else{//miembro creado correctamente se muestran los datos con los cuales se ha creado el miembro
                               
                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Miembro creado correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                echo '
                                 <h1>Miembro correctamente creado con los siguientes datos:</h1>
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
                            $conn->close();
                            exit();
                        }
                        else {
                            //Si existe un miembro con el DNI o nombre de usuario introducidos.
                            if($row2['existe2'] == 0){
                                echo "Error miembro coincide con otro que ya existe en el sistema. <a href=\"anadirmiembro.php\">Introduzca otro válido</a><br>";
                            }
                            else{
                                echo "Error miembro coincide con otro que ya existe en el sistema  <a href=\"anadirmiembro.php\">introduce otro diferente</a><br>";
                            }

                            //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear el miembro";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);
                        }
                }
            } 
        else{    /*Si no se han pasado datos por POST entonces significa que vamos a crear un nuevo miembror por tanto imprime la tabla
                  * con los inputs correspondientes para insertar los datos del miembro  los cuales se reenviarán a esta misma página
                 * una vez que se pulse el boton de submit 
                 */
        

        ?>
        <form  name="fcrear" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" onsubmit=" return comprobacionDatos(&quot;fcrear&quot;)" method="POST">
                        <table>                
               
                <tr>
                    <td>Nombre:</td>
                    <td><p><input type="text" name="nombre"/></p></p><p id="nombre"></p></td>
                </tr>
                <tr>
                    <td>Primer Apellido:</td>
                    <td><p><input type="text" name="primerApellido"/></p><p id="primerApellido"></p></td>
                </tr>
                <tr>
                    <td>Segundo Apellido:</td>
                    <td><p><input type="text"  name="segundoApellido"></p><p id="segundoApellido"></p></td>
                </tr>
                <tr>
                    <td>Categoría:</td>
                    <td><p><input type="text"  name="categoria"></p><p id="categoria"></p></td>
                </tr>
                <tr>
                    <td>Director:</td>
                    <td><p><input type="text"  name="director"><p id="director"></p></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><p><input type="text"  name="email"><p id="email"></p></td>
                </tr>
                <tr>
                    <td>Contraseña:</td>
                    <td><p><input type="text"  name="password"><p id="password"></p></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td><p><input type="text"  name="integrantes"><p id="curso"></p></td>
                </tr>
                <tr>
                    <td>Url:</td>
                    <td><p><input type="text"  name="url"><p id="url"></p></td>
                </tr>  
                <tr>
                    <td>Departamento:</td>
                    <td><p><input type="text"  name="departamento"><p id="departamento"></p></td>
                </tr> 
                    <tr>
                    <td>Centro:</td>
                    <td><p><input type="text"  name="centro"><p id="centro"></p></td>
                </tr>  
                    <tr>
                    <td>Institución:</td>
                    <td><p><input type="text"  name="institucion"><p id="institucion"></p></td>
                </tr> 
                <tr>
                    <td>Dirección:</td>
                    <td><p><input type="text"  name="direccion"><p id="direccion"></p></td>
                </tr> 
                <tr>
                    <td>Activo:</td>
                    <td><p><input type="text"  name="activo"><p id="activo"></p></td>
                </tr> 
                <tr>
                    <td>Permiso:</td>
                    <td><p><input type="text"  name="permiso"><p id="permiso"></p></td>
                </tr>              
                            

                </table>
                <input type="submit" value="Dar de alta miembro.">
                </form>
            <?php };
            
            $conn->close()?>
        </div>
    </div> 
    </body>

        
   
    <div style="right: 0px; width: 404px; position: absolute; bottom: -650px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>



</html>