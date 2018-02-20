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
        <div class='container-cabecera'>
                <?php include 'cabecera.php' ?>
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

            <div>
            <p>
               La Ley y la Propiedad Intelectual, el Copyright /Derecho de autor.

            La propiedad Intelectual es el primer derecho de los que diseñan; inventan  o crean. 
            Es la propia creación que genera por ella misma el derecho de autor. También llamado copyright, 
            puede en ciertos casos ser "especializarse": marcas, patentes de invención…) ; o ser el único derecho 
            posible existente (texto, proyecto, canción, contenido de sitio Web, concepto. Dibujo, foto, logotipo…).  
            Sin embargo, aunque habrá que facilitar pruebas sólidas, siempre es necesario proteger este derecho. 
            Y esto es posible por intermedio del depósito.<br/><br/>

            Todo el material publicado en esta página está protegido por la Ley de Propiedad Intelectual. 
            En particular, queda expresamente prohibido su uso y distribución por cualquier medio sin
             autorización del autor (esto incluye repositorios de internet como, por ejemplo, GitHub).

            El autor da autorización expresa a los alumnos de esta asignatura para su uso particular en 
            l estudio de la misma.
 
            </p>    
            </div>        

        
        </div>
    </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>

    </body>
</html>
