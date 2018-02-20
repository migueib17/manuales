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
  <table>
      <caption><h1>Autores:</h1></caption>
      <tbody>
          <tr>
              <td><img src="imagenes/miguel.png" alt="miguel" id="miguel"></td>
              <td><h3>Miguel Fernández Fernández</h3></td>
              <td><h4>migueib17@correo.ugr.es</h4></td>
          </tr>
          <tr>
              <td><img src="imagenes/yurena.png" alt="yurena" id="yurena"></td>
              <td><h3>Yurena del Peso Pérez</h3></td>
              <td><h4>yurenadel@correo.ugr.es</h4></td>
          </tr>
      </tbody>
  </table>
            
       
            
  
    </div>     

        
        </div>
    </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>

    </body>
</html>
