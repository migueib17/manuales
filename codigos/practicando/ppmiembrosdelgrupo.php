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
                  <td><input type="submit" onClick='' value="Ver" name='<?php echo $row['nombre'] ?>' /></input></td>
                  <?php

        
                    if(isset($_POST[$row['nombre']])){

                    	$_SESSION['id_miembro' ]=$row['id_miembro'];
                                 print("<script>window.location.assign('pplistarMiembroCompleto.php');</script>");
    
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
