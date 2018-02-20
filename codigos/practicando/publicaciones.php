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
            $conexion=conectar();
            $mysql0="SELECT * FROM publicaciones ORDER BY fechaPublicacion";
            $result=mysqli_query($conexion,$mysql0);
          ?>

                <div class='container-display'>
                    <h1>Lista de Publicaciones:</h1>
                    <form name="formulario" action=""  method="post">
                    <table>
                            <tr>
                                <th>DOI</th>
                                <th>Tipo</th>
                                <th>Título</th>
                                <th>Autores</th>
                                <th>Url</th>
                                <th>Fecha de publicación</th>
                            </tr>


                    <?php
              while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                ?>
                <tr>
                  <td><?php echo $row['doi'] ?></td>
                  <td><?php echo $row['tipo'] ?></td>
                  <td><?php echo $row['titulo'] ?></td>
                  <td><?php echo $row['autores'] ?></td>
                  <td><?php echo $row['url'] ?></td>
                  <td><?php echo $row['fechaPublicacion'] ?></td>
                  <td><input type="submit" onClick='' value="Ver" name='<?php echo $row['doi'] ?>' /></input></td>
                  <?php

                    
                    if($_POST[$row['doi']]){
                      $_SESSION['doi']=$row['doi'];
                  
                      print("<script>window.location.assign('pplistarPublicaciones.php');</script>");
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
