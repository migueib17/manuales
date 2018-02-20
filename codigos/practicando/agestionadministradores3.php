<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type']!='admin') {
    header("Location: adminlogin.php");
    die();
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gestión de administradores</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
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
                                    <a href="acrearadministrador.php">Dar de alta administrador</a>
                                    <a class="menu_lateral_selected" href="agestionadministradores.php">Gestión de administradores</a>
                                    <a href="acrearmiembro.php">Dar de alta miembro</a>
                                    <a href="agestionmiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
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
                    <div class="logout">
                                <form align="right" name="formlogout" method="post" action="logout.php">
                                <label>
                                    <input name="submitlogout" type="submit" id="submit2" value="Cerrar sesión.">
                                </label>
                                </form>
                    </div>
                </div>
                <div class='container-display'>
                <h1>Gestionar administradores del sistema:</h1>
                    <?php    
                    
                    /*Creamos un tabla contenida en un formulario  
                     *donde en cada fila de la tabla se mostrarán los datos de un administrador y al lados de sus datos un botón de submit.
                     *Cada botón de submit está identificado por el DNI del miembro cuyos datos estan en la fila que lo contiene asi que al pulsar
                     * el botón de submit se enviará un código que identifica que submit que se ha pulsado y la`página amodificaradminsitrador
                     *  sabrá los datos de que administrador mostrar.
                     */
                        echo '
                        <form  name="fgestionar" action="amodificaradministrador.php"  method="post">
                            <table>
                                <tr>
                                    <th>Nombre</th>
                                    <th>DNI</th>
                                    <th>Email</th>

                                </tr>
                        ';

                        //Obtenemos los datos de todos los miembroes de la base de datos
                        $sql = "SELECT dni, email, nombre  FROM usuarios WHERE type= \"admin\" ORDER BY nombre;";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                        
                            while($row = $result->fetch_assoc()){//e imprimimos una fila para cada administrador con sus datos y un botón submit
                                echo '<tr>';          
                                echo "<td>" . $row["nombre"]. "</td>";                  
                                echo "<td>" . $row["dni"]. "</td>";
                                echo "<td>" . $row["email"]. "</td>";
                                echo '<td><input type="submit" value="Gestionar" name="cod'.$row["dni"].'" />';
                                echo '</td>';
                            }
                        };
                        echo '</table>';
                       echo ' </form>';
                       $conn->close();
                    ?>  
                </div>
            </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>