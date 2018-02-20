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
                                <a class="menu_lateral_selected" href=ppproyectos.php>Proyectos</a>
                                <a href=publicaciones.php>Publicaciones</a>
                            </ul>
                    </div>
           
                </div>
                


        <?php
            include('funcionabilidad.php');
            $conexion=conectar();
            $mysql0="SELECT * FROM proyectosInvestigacion";
            $result=mysqli_query($conexion,$mysql0);
          ?>

                <div class='container-display'>
                    <h1>Lista de Proyectos:</h1>
                    <form name="formulario" action=""  method="post">
                    <table>
                            <tr>
                                <th>Título</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                            </tr>


                    <?php
              while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                ?>
                <tr>
                  <td><?php echo $row['titulo'] ?></td>
                  <td><?php echo $row['fechaInicio'] ?></td>
                  <td><?php echo $row['fechaFin'] ?></td>
                  <td><input type="submit" onClick='' value="Ver" name='<?php echo $row['titulo'] ?>' /></input></td>
                  <?php

        
                    if($_POST[$row['titulo']]){
                      $_SESSION['id_proyecto']=$row['id_proyecto'];
                      print("<script>window.location.assign('pplistarProyectos.php');</script>");
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
