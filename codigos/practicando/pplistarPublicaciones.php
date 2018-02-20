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
                                <a href=ppmiembrosdelgrupo.php>Miembros del grupo</a>
                                <a href=ppproyectos.php>Proyectos</a>
                                <a class="menu_lateral_selected" href=publicaciones.php>Publicaciones</a>
                            </ul>
                    </div>
                  
                </div>


          <?php

            include('funcionabilidad.php');
            $var=$_SESSION["doi"];
            $conexion=conectar();
            $mysql="SELECT * FROM publicaciones WHERE doi='$var'";
            $result=mysqli_query($conexion,$mysql);

          ?>


            <div class='container-display'>
                    <h1>Información de publicación: </h1>
                    <table>
                <tr>
                   <th>ID proyecto</th>
                    <th>ID publicación</th>
                    <th>DOI</th>
                    <th>Tipo</th>
                    <th>Título</th>
                    <th>Autores</th>
                    
                </tr>


              <?php
               ($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                ?>
              <tr>
                     <td><?php echo $row['id_proyec'] ?></td>
                    <td><?php echo $row['id_publicacion'] ?></td>         
                    <td><?php echo $row['doi'] ?></td>
                    <td><?php echo $row['tipo'] ?></td>                  
                    <td><?php echo $row['titulo'] ?></td>
                    <td><?php echo $row['autores'] ?></td>
                    
              </tr>
                    </table>
              <br><br>
                    <table>
                 <tr>
                    <th>Fecha de Publicación</th>
                    <th>Url</th>
                    <th>Resumen</th>
                    <th>Palabras</th>
                  
                </tr>



               <tr>
                   <td><?php echo $row['fechaPublicacion'] ?></td>
                    <td><?php echo $row['url'] ?></td>        
                    <td><?php echo $row['resumen'] ?></td>
                    <td><?php echo $row['palabras'] ?></td>                  
           
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
