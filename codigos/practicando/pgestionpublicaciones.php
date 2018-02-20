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
        <title>Gestionar publicaciones.</title>
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
                                    <a href=amodificarmiembropropio.php>Modificar mis datos</a>
                                    
                                    ';
                                }
                                }
                                ?> 
                            </ul>
                    </div> 

                </div>



        <div class='container-display'>
        <h1>Gestión de publicaciones:</h1> 
               
    
        <form  name="formulario" action=""  method="post">
            <table>
                <tr>
                    <th>ID proyecto</th>
                    <th>ID publicación</th>
                    <th>DOI</th>
                    <th>Tipo</th>
                    <th>Título</th>
                    <th>Autores</th>
                    <th>Fecha de Publicación</th>
                    <th>Url</th>
                </tr>
             

 <?php  
        //Obtenemos los datos de todos los publicacions de la base de datos
            $sql = "SELECT * FROM publicaciones ORDER BY fechaPublicacion;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()){ //e imprimimos una fila para cada miembro con sus datos y un botón submit
    ?>
                    <tr>  
                    <td><?php echo $row['id_proyec'] ?></td>
                    <td><?php echo $row['id_publicacion'] ?></td>         
                    <td><?php echo $row['doi'] ?></td>
                    <td><?php echo $row['tipo'] ?></td>                  
                    <td><?php echo $row['titulo'] ?></td>
                    <td><?php echo $row['autores'] ?></td>
                    <td><?php echo $row['fechaPublicacion'] ?></td>
                    <td><?php echo $row['url'] ?></td>
                    <td><input type="submit" onClick='' value="Gestionar" name='<?php echo $row["doi"] ?>' /></input></td>
                   
    <?php  
                         if($_POST[$row['doi']]){
                              $_SESSION['doi']=$row['doi'];
                    
                                    print("<script>window.location.assign('pmodificarpublicacion.php');</script>");
                            }

                         }
                     }

    ?>
             </tr>
            </table>
           </form>
         
           
        </div>
        </div>
  <div style="right: 0px; width: 404px; position: absolute; bottom: -250px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>
    </body>
</html>