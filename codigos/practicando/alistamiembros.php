<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    die();
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gestión de miembros</title>
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
                                    ';

                                }
                                }
                                ?> 
                            </ul>
                    </div> 

                </div>  


        <?php
            include('funcionabilidad.php');
            $conexion=conectar();
            $mysql0="SELECT * FROM miembros";
            $result=mysqli_query($conexion,$mysql0);
          ?>

                <div class='container-display'>
                    <h1>Miembros del grupo:</h1>
                    <form  name="formulario" action=""  method="post">
                    <table>
                            <tr>
                                <th>Nombre</th>
                                <th>1º Apellido</th>
                                <th>2º Apellido</th>
                                <th>Email</th>
                                <th>Info</th>
                            </tr>


                    <?php
           while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                ?>
                <tr>
                  <td><?php echo $row['nombre'] ?></td>
                  <td><?php echo $row['primerApellido'] ?></td>
                  <td><?php echo $row['segundoApellido'] ?></td>
                  <td><?php echo $row['email'] ?></td>
                  <td><input type="submit" onClick='' value="Gestionar Información" name='<?php echo $row["nombre"] ?>' /></input></td>
                   

    <?php 
 


                    if(isset($_POST[$row['nombre']])){
                              $_SESSION['email']=$row['email'];
                              echo $_SESSION['email'];
                                    print("<script>window.location.assign('amodificarmiembroinfo.php');</script>");
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
