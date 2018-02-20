<?php

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>index</title>
        <?php include 'inicioSesionMySQL.php';?>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
    </head>
    <body>
            <div class='container-cabecera'>
                <?php include 'cabecera.php' ?>

            </div>

            <div class='container-cuerpo'>
                <div class='container-menu'>
                    <div class="menu_lateral">
                            <ul>
                                <a href=modulovisualizacion.php>Inicio</a>
                                <a class="menu_lateral_selected" href=ppmiembrosdelgrupo.php>Miembros del grupo</a>
                                <a href=ppproyectos.php>Proyectos</a>
                                <a href=publicaciones.php>Publicaciones</a>
                            </ul>
                    </div>
               
                </div>


          <?php

            include('funcionabilidad.php');
            $id_miembro=$_SESSION["id_miembro"];
            $conexion=conectar();
            $mysql="SELECT * FROM miembros WHERE id_miembro='$id_miembro'";
            $result=mysqli_query($conexion,$mysql);

          ?>


            <div class='container-display'>
                    <h1>Información extendida: </h1>
                    <table>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>1º Apellido</th>
                                <th>2º Apellido</th>
                                <th>Email</th>
                                <th>Tlf</th>

                            </tr>
              <?php
               ($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                ?>
              <tr>
                <td><?php echo $row['foto'] ?></td>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php echo $row['primerApellido'] ?></td>
                <td><?php echo $row['segundoApellido'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['telefono'] ?></td>
              </tr>
                    </table>
              <br><br>
                    <table>
               <tr>
                                <th>Centro</th>
                                <th>Departamento</th>
                                <th>Categoría</th>
                                <th>Web</th>
                                <th>Director</th>
                                <th>Dirección</th>
                                <th>Activo</th>  

                </tr>



               <tr>
                <td><?php echo $row['centro'] ?></td>
                <td><?php echo $row['departamento'] ?></td>
                <td><?php echo $row['categoria'] ?></td>
                <td><?php echo $row['url'] ?></td>
                <td><?php echo $row['director'] ?></td>
                <td><?php echo $row['direccion'] ?></td>
                <td><?php echo $row['activo'] ?></td>
              </tr>

              </tr>
            </table>
    
                </div>
                
            </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>
