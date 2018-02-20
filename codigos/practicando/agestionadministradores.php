<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type']!='admin') {
    header("Location: adminlogin.php");
    die();
} 

include('log.php');
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

        <?php

            /*Creamos un tabla contenida en un formulario  
                     *donde en cada fila de la tabla se mostrarán los datos de un administrador y al lados de sus datos un botón de submit.
                     *Cada botón de submit está identificado por el DNI del miembro cuyos datos estan en la fila que lo contiene asi que al pulsar
                     * el botón de submit se enviará un código que identifica que submit que se ha pulsado y la`página amodificaradminsitrador
                     *  sabrá los datos de que administrador mostrar.
                     */
          ?>
        <?php  
                        //Obtenemos los datos de todos los miembroes de la base de datos
                        $sql = "SELECT dni, email, nombre  FROM usuarios WHERE type= \"admin\" ORDER BY nombre;";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                 ?>
                <div class='container-display'>
                <h1>Gestionar administradores del sistema:</h1>
                        <form  name="formulario" action=""  method="post">
                            <table>
                                <tr>
                                    <th>Nombre</th>
                                    <th>DNI</th>
                                    <th>Email</th>
                                </tr>
               

                 <?php        
                            while($row = $result->fetch_assoc()){//e imprimimos una fila para cada administrador con sus datos y un botón submit
                ?> 
                            <tr>         
                                <td><?php echo $row['nombre'] ?></td>                
                                <td><?php echo $row['dni'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><input type="submit" onClick='' value="Gestionar" name='<?php echo $row["dni"] ?>' /></input></td>
                <?php

        
                         if($_POST[$row['dni']]){
                              $_SESSION['dni']=$row['dni'];
                                    print("<script>window.location.assign('amodificaradministrador.php');</script>");
                            }

                         }
                     }
                       
                ?>  
                             </tr>

                            </table>
                    </form>
                </div>
            </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>