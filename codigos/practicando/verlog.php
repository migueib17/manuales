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
            <div class='container-display'>
                <b id="fechactual"> Fecha actual:
                    
                    <?php echo  date("d-m-Y H:i:s")?>
                    </b>
                    </bf>

            <div>


<?php
$the_array = Array();
$handle = opendir('logs/.');
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   $the_array[] = $file;
   }
}
closedir($handle);
sort ($the_array);
while (list ($key, $val) = each ($the_array)) {
   echo "<a href=logs/$val>$val</a><br>";
}
?>

            </div>        

        
        </div>
    </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>

    </body>
</html>
