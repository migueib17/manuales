<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio</title>
        <?php include 'inicioSesionMySQL.php'; ?>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
    </head>
    <body>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <div class='container-cabecera'>
                <?php include 'cabecera.php'; 
                    include('log.php');

                ?>
        </div>
        <div class='container-cuerpo'>
            <div class='container-menu'>
                    <div class="menu_lateral">
                            <ul>
                                <a class="menu_lateral_selected" href=modulovisualizacion.php>Inicio</a>
                                <a href=ppmiembrosdelgrupo.php>Miembros del grupo</a>
                                <a href=ppproyectos.php>Proyectos</a>
                                <a href=publicaciones.php>Publicaciones</a>
                            </ul>
                    </div> 

            </div>
            <div class='container-display'>
                <b id="fechactual"> Fecha actual:
                    
                    <?php echo  date("d-m-Y H:i:s")?>
                    </b>
                    </bf>


            </div>
        </div>

        <br><br>
        <div>
            

            <img src="imagenes/logoazul.png" alt="logoazul" id="logoazul">

        </div>

 
        <footer>
            <?php include 'footer.php' ?>
        </footer>

    </body>
</html>
