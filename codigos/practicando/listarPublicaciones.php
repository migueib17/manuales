<?php
session_start()
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
                                <a href=miembrosdelgrupo.php>Miembros del grupo</a>
                                <a href=proyectos.php>Proyectos</a>
                                <a class="menu_lateral_selected" href=publicaciones.php>Publicaciones</a>
                            </ul>
                    </div>
                    <?php include 'login_buttom.php' ?>
                </div>


          <?php

            include('funcionabilidad.php');
            $id_proyecto=$_SESSION["id_proyecto"];
            $conexion=conectar();
            $mysql="SELECT * FROM proyectosInvestigacion WHERE id_proyecto='$id_proyecto'";
            $result=mysqli_query($conexion,$mysql);

          ?>


            <div class='container-display'>
                    <h1>Información de proyecto: </h1>
                    <table>
                            <tr>
                                <th>Codigo</th>
                                <th>Título<th>
                                Investigador Responsable
                                <th>Integrantes</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de finalización</th>
                            </tr>


              <?php
               ($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                ?>
              <tr>
                <td><?php echo $row['codigo'] ?></td>
                <td><?php echo $row['titulo'] ?></td>
                <td><?php echo $row['responsable'] ?></td>
                <td><?php echo $row['integrantes'] ?></td>
                <td><?php echo $row['fechaInicio'] ?></td>
                <td><?php echo $row['fechaFin'] ?></td>
              </tr>
                    </table>
              <br><br>
                    <table>
               <tr>
                            <th>Descripción</th>
                            <th>Entidades Colaboradoras</th>
                            <th>Cuantia</th>
                            <th>URL</th>

                </tr>



               <tr>
                    <td><?php echo $row['descrpcion'] ?></td>
                    <td><?php echo $row['entidadesColaboradoras'] ?></td>
                    <td><?php echo $row['cuantia'] ?></td>
                    <td><?php echo $row['url'] ?></td>
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
