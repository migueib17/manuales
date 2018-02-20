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
    <title>Dar de alta miembro</title>
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
                                    <a class="menu_lateral_selected" href="acrearmiembro.php">Dar de alta usuario-miembro</a>
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
        <h1>Crear usuario del sistema:</h1>
            <?php
            /* Si recibe datos para crear miembro lo crea y muestra mensaje de que todo esta correcto sino imprime el formulario para 
                crear el miembro
             **/
            if (!empty($_POST['nombre'])  && !empty($_POST['usuario']) && !empty($_POST['dni']) && 
                !empty($_POST['contraseña']) && !empty($_POST['email']) && !empty($_POST['type'])
            ){

                    $sql = "SELECT COUNT(dni) as existe FROM usuarios WHERE dni =\"" . $_POST['dni'] . "\" ;";
                    $sql2 = "SELECT COUNT(username)as existe2 FROM usuarios WHERE username =\"" . $_POST['usuario'] . "\" ;";
                    //Vemos si hay  miembroes con el mismo DNI o nombre de usuario
                    $result = $conn->query($sql);
                    $result2= $conn->query($sql2);
                    if (($result->num_rows > 0) && ($result2->num_rows > 0)) {
                        
                        $row = $result->fetch_assoc();
                        $row2= $result2->fetch_assoc();
                        if( $row['existe'] == 0 && $row2['existe2'] == 0){                         
                        //Si no hay ya un miembro con el mismo DNI o nombre de usuario insertamos datos
                            
                            $sql = "INSERT INTO usuarios (dni, email, nombre, password, type, username)"
                            . " VALUES (\"" . $_POST['dni'] . "\" , \"" . $_POST['email'] . "\" , \"" . $_POST['nombre'] . "\" , \"" . md5($_POST['contraseña']) . "\" , \"" 
                            . $_POST['type'] . "\" , \"" . $_POST['usuario'] . "\"  )" ;
                    
                            if ($conn->query($sql) === FALSE) {                 //Si se produce fallo al crear el miembro que lo vuelva a intentar
                                
                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la creación del usuario-miembro";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                echo "Error: en la creación del usuario-miembro por favor <a href=\"acrearmiembro.php\">vuelva a intentarlo<br>";
                                $conn->close();
                                exit();
                             }
                            else{//miembro creado correctamente se muestran los datos con los cuales se ha creado el usuario-miembro
                               
                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Usuario correctamente creado";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                echo '
                                <h1>Usuario correctamente creado con los siguientes datos:</h1>
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
                                </tr>
                                <tr>
                                    <td>Contaseña</td>
                                    <td>' . $_POST['contraseña'] .'</td>
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
                                echo "Error miembro con DNI introducido ya existe en el sistema. <a href=\"acrearmiembro.php\">Introduzca DNI valido</a><br>";
                            }
                            else{
                                echo "Error nombre de usuario ya existe en el sistema  <a href=\"acrearmiembro.php\">introduce otro diferente</a><br>";
                            }


                            //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la creación del usuario";

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
                            <td>Nombre y apellidos</td>
                            <td><p><input type="text"   name="nombre"></p><p id="nombre"></p></td>
                        </tr>
                        <tr>
                            <td>DNI</td>
                            <td><p><input type="text" name="dni"/></p></p><p id="dni"></p></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><p><input type="text" name="email"/></p><p id="email"></p></td>
                        </tr>
                        <tr>
                            <td>Nombre usuario</td>
                            <td><p><input type="text"  name="usuario"></p><p id="usuario"></p></td>
                        </tr>
                        <tr>
                            <td>Contaseña</td>
                            <td><p><input type="password"  name="contraseña"></p><p id="contraseña"></p></td>
                            <input type="hidden" name="type" value="profesor">
                        </tr>                    
                        </table>
                <input type="submit" value="Dar de alta miembro.">
                </form>
            <?php };
            
            $conn->close()?>
        </div>
    </div> 
    <footer>
            <?php include 'footer.php' ?>
        </footer>
</body>
</html>