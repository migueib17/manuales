<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type']!='admin') {
    header("Location: adminlogin.php");
    die();
}

    include('log.php')

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dar de alta administrador.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="javascript/ejercicio/ejercicio.js"></script> 
        <?php include 'inicioSesionMySQL.php'; ?>
        
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
                                    <a class="menu_lateral_selected" href="acrearadministrador.php">Dar de alta administrador</a>
                                    <a href="agestionadministradores.php">Gestión de administradores</a>
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
                <h1>Añadir administrador del sistema:</h1>
                    <?php
                        /* Si recibe datos para crear administrador lo crea y muestra mensaje de que todo esta correcto sino muestra el formulario para 
                            crear el administrador
                         *              */
                        if (!empty($_POST['nombre'])  && !empty($_POST['usuario']) && !empty($_POST['dni']) && 
                            !empty($_POST['contraseña']) && !empty($_POST['email']) && !empty($_POST['type'])
                        ){

                                $sql = "SELECT COUNT(dni) as existe FROM usuarios WHERE dni =\"" . $_POST['dni'] . "\" ;";
                                $sql2 = "SELECT COUNT(username)as existe2 FROM usuarios WHERE username =\"" . $_POST['usuario'] . "\" ;";
                                //Vemos si hay  administradores con el mismo DNI o nombre de usuario
                                $result = $conn->query($sql);
                                $result2= $conn->query($sql2);
                                if (($result->num_rows > 0) && ($result2->num_rows > 0)) {

                                    $row = $result->fetch_assoc();
                                    $row2= $result2->fetch_assoc();
                                    if( $row['existe'] == 0 && $row2['existe2'] == 0){

                                    //Si no hay ya un administrador con el mismo DNI o nombre de usuario insertamos datos

                                        $sql = "INSERT INTO usuarios (dni, email, nombre, password, type, username)"
                                        . " VALUES (\"" . $_POST['dni'] . "\" , \"" . $_POST['email'] . "\" , \"" . $_POST['nombre'] . "\" , \"" . md5($_POST['contraseña']) . "\" , \"" 
                                        . $_POST['type'] . "\" , \"" . $_POST['usuario'] . "\"  )" ;

                                        if ($conn->query($sql) === FALSE) {                 //Si se produce fallo al crear el administrador que lo vuelva a intentar
                                           
                                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la creación del administrador";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                            echo "Error: en la creación del administrador porfavor <a href=\"acrearadministrador.php\">vuelva a intentarlo<br>";
                                            $conn->close();
                                            exit();
                                         }
                                        else{ //Administrador creado correctamente se muestran los datos con los cuales se ha creado el administrador
                                            


                                                    //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Administrador creado correctamente";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                            echo '
                                            <h1>Administrador correctamente creado con los siguientes datos:</h1>
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
                                    else { //Si existe un administrador con el DNI o nombre de usuario introducidos.
                                        if($row2['existe2'] == 0){
                                            echo "Error administrador con DNI introducido ya existe en el sistema. <a href=\"acrearadministrador.php\">Introduzca DNI valido</a><br>";
                                        }
                                        else{
                                            echo "Error nombre de usuario ya existe en el sistema  <a href=\"acrearadministrador.php\">introduce otro diferente</a><br>";
                                        }

                                            //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error: en la creación del administrador";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                    }
                                }
                        } 
                    else{   /*Si no se han pasado datos por POST entonces significa que vamos a crear un nuevo administrador por tanto imprime la tabla
                            * con los inputs correspondientes para insertar los datos del administrador  los cuales se reenviarán a esta misma página
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
                                        <input type="hidden" name="type" value="admin">
                                    </tr>                    
                                </table>
                            <input type="submit" value="Dar de alta administrador.">
                    </form>
                    <?php }
                    $conn->close();
                    ?>  
                </div>
            </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>
