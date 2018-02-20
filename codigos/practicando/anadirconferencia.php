<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    die();
} 
include('log.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <html lang="en">
<head>
    <meta charset="utf-8">
    <title>Añadir conferencia.</title>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="javascript/jquery/jquery-1.10.2.js"></script>
    <script src="javascript/jquery/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="javascript/ejercicio/ejercicio.js"></script> 
    <?php    include 'inicioSesionMySQL.php'; ?>


<script>


</script>
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
                                    <a href="agestionadministradores.php">Gestión de administradores</a>
                                    <a href="acrearmiembro.php">Dar de alta usuario-miembro</a>
                                    <a href="agestionmiembros.php">Gestión de usuario-miembro</a>
                                    <a href="anadirmiembro.php">Añadir miembro</a>
                                    <a href="alistamiembros.php">Gestión de miembros</a>
                                    <a href="pcrearproyecto.php">Añadir proyecto</a>
                                    <a href="pgestionproyectos.php">Gestión de proyectos</a>
                                    <a class="menu_lateral_selected" href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    ';
                                }elseif($_SESSION['type']=='profesor'){

                                    echo '
                                    <a href=pcrearproyecto.php>Añadir proyecto</a>
                                    <a href=pgestionproyectos.php>Gestión de proyectos</a>
                                    
                                    <a class="menu_lateral_selected" href="anadirpublicacion.php">Añadir publicación</a>
                                    <a href="pgestionpublicaciones.php">Gestionar publicaciones</a>
                                    <a href=amodificarmiembropropio.php>Modificar mis datos</a>
                                    ';
                                }
                                }
                                ?> 
                            </ul>
                    </div> 

                </div>
        <div class='container-display'>
        <h1>Crear publicación:</h1>
            <?php
            /* Si recibe datos para crear publicacion lo crea y muestra mensaje de que todo esta correcto sino imprime el formulario para 
                crear el publicacion
             **/


            if (!empty($_POST['titulo'])  && !empty($_POST['autores'])){

                    $sql = "SELECT COUNT(doi) as existe FROM publicaciones WHERE doi =\"" . $_POST['doi'] . "\" ;";
                    $result = $conn->query($sql);

                    if (($result->num_rows > 0)) {  
                        $row = $result->fetch_assoc();
                 
    
                        if( $row['existe'] == 0 ){                         
                        //Si no hay ya un publicacion con el mismo insertamos datos

                            $sql="INSERT INTO publicaciones (id_proyec, tipo, doi, titulo, autores, fechaPublicacion, resumen, palabras, url, id_proyecto) 
                               VALUES ( \"" . $_POST['id_proyec'] . "\" , 'conferencia' , \"" . $_POST['doi'] . "\" , \"" . $_POST['titulo'] . "\" ,
                                \"" . $_POST['autores'] . "\" , \"" . $_POST['fechaPublicacion'] . "\" , \"" . $_POST['resumen'] . "\" , 
                                \"" . $_POST['palabras'] . "\", \"" . $_POST['url'] . "\" , NULL)" ;

                        
                    
                                // echo "<script> alert({$_POST['id_publicacion']});</script>";
                 
                            if (($conn->query($sql) === FALSE)) {                 //Si se produce fallo al crear el publicacion que lo vuelva a intentar
                                
                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear la publicacion";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);


                                echo "Error: en la creación de la publicación por favor <a href=\"anadirpublicacion.php\">vuelva a intentarlo<br>";
                                $conn->close();
                                exit();

                            } 

                            else {//publicacion creado correctamente se muestran los datos con los cuales se ha creado el publicacion

                                $sql3 = "SELECT id_publicacion, doi FROM publicaciones"; 
                                    $result3 = $conn->query($sql3);


                                    if ($result3->num_rows > 0) { 
                                         while($row = $result3->fetch_assoc()){ //e imprimimos una fila para cada doi con sus datos y un botón submit

    ?>
                                         
                                            
    <?php
                                             $_SESSION['$idpubli']=$row['id_publicacion'];
                                        
                                              //  echo "<script> alert({$_POST['id_publicacion']});</script>";

                                            $sql2="INSERT INTO conferencias (id_publicaciones, nombre, lugar, resena) 
                                            VALUES ( \"" . $_SESSION['$idpubli'] . "\" , \"" . $_POST['nombre'] . "\" , \"" . $_POST['lugar'] . "\" , \"" . $_POST['resena'] . "\")" ;

                                    
                                            if (($conn->query($sql2) === FALSE)) {                 //Si se produce fallo al crear el publicacion que lo vuelva a intentar
                                                
                                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear la publicacion";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                                echo "Error: en la creación de la publicación conferencia por favor <a href=\"anadirpublicacion.php\">vuelva a intentarlo<br>";
                                                 $conn->close();
                                                exit();

                                              }
                                            else {

                                                //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Exito al crear la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);

                                                    echo '
                                                     <h1>Publicación correctamente creada con los siguientes datos:</h1>
                                                    <table>
                                                    <tr>
                                                        <td>ID publicacion:</td>
                                                        <td>' . $_POST['id_publicacion'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID proyecto:</td>
                                                        <td>' . $_POST['id_proyec'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tipo:</td>
                                                        <td> ' . $_POST['tipo'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>DOI:</td>
                                                        <td>' . $_POST['doi'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Título:</td>
                                                        <td>' . $_POST['titulo'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Autores:</td>
                                                        <td>' . $_POST['autores'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fecha de Publicación:</td>
                                                        <td>' . $_POST['fechaPublicacion'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Resumen:</td>
                                                        <td>' . $_POST['resumen'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Palabras:</td>
                                                        <td>' . $_POST['palabras'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Url:</td>
                                                        <td>' . $_POST['url'] .'</td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td>Nombre de la conferencia:</td>
                                                        <td>' . $_POST['nombre'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lugar:</td>
                                                        <td>' . $_POST['lugar'] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Reseña:</td>
                                                        <td>' . $_POST['resena'] .'</td>
                                                    </tr>
                                                    
                                                                              
                                                    </table>
                                                    ';



                                                }
                                                $conn->close();
                                                exit();
                                        }
                                    }
                                }
                            }
                              } 
                        else {
                            //Si existe un publicacion con el DNI o nombre de usuario introducidos.
                            if($row2['existe2'] == 0){
                                echo "Error publicación coincide con otro que ya existe en el sistema. <a href=\"anadirpublicacion.php\">Introduzca otro válido</a><br>";
                            }
                            else{
                                echo "Error publicación coincide con otro que ya existe en el sistema  <a href=\"anadirpublicacion.php\">introduce otro diferente</a><br>";
                            }

                              //INFORMACION DEL EVENTO PARA EL LOG

                                            $username=$_SESSION["username"];

                                            $accion="Error al crear la publicación";

                                            $origen=$_SERVER['REMOTE_ADDR'];

                                            generaLogs($username,$accion,$origen);
                        }
                }
       
          
        else{    /*Si no se han pasado datos por POST entonces significa que vamos a crear un nuevo publicacionr por tanto imprime la tabla
                  * con los inputs correspondientes para insertar los datos del publicacion  los cuales se reenviarán a esta misma página
                 * una vez que se pulse el boton de submit 
                 */
        

        ?>
        <form  name="fcrear" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" onsubmit=" return comprobacionDatos(&quot;fcrear&quot;)" method="POST">


               
                      <table>                
                <tr>
               
                    <td><label for="tipopubli">Tipo de publicación:</label> </td><br/>
                    <td> <select id="tipopubli" name="tipopubli" onchange="location = this.value;">
                             <option value="" selected="selected">- selecciona -</option>

                             <option value="anadirrevista.php">Artículo de Revista</option>
                             <option value="anadirlibro.php">Libro</option>
                             <option value="anadircapitulo.php">Capítulo</option>
                             <option value="anadirconferencia.php" selected="selected">Conferencia</option>
                        </select>

                    </td>
                     <td>Nombre de la conferencia:</td>
                    <td><p><input type="text" name="nombre"/></p></p><p id="nombre"></p></td>  
                    
                    
              
                </tr>
                <tr>
                    <td>ID proyecto:<br/>
                    <p id="chica">(Obligatorio: "correspondencia ID proyecto")</p>
                        </td>
                    <td><p><input type="text"  name="id_proyec"><p id="id_proyec"></p></td>
                    <td>Lugar:</td>
                    <td><p><input type="text" name="lugar"/></p></p><p id="lugar"></p></td>
                </tr>
                <tr>
                    <td>DOI:</td>
                    <td><p><input type="text" name="doi"/></p></p><p id="doi"></p></td>
                    <td>Reseña de la publicación:</td>
                    <td><p><input type="text" name="resena"/></p></p><p id="resena"></p></td>
                </tr>
                <tr>
                    <td>Título:</td>
                    <td><p><input type="text" name="titulo"/></p><p id="titulo"></p></td>
                </tr>
                <tr>
                    <td>Autores:</td>
                    <td><p><input type="text"  name="autores"></p><p id="autores"></p></td>
                </tr>
                <tr>
                    <td>Fecha de Publicación:</td>
                    <td><p><input type="date"  name="fechaPublicacion"></p><p id="fechaPublicacion"></p></td>
                </tr>
                <tr>
                    <td>Resumen:</td>
                    <td><p><input type="text"  name="resumen"><p id="resumen"></p></td>
                </tr>
                <tr>
                    <td>Palabras:</td>
                    <td><p><input type="text"  name="palabras"><p id="palabras"></p></td>
                </tr>
                <tr>
                    <td>Url:</td>
                    <td><p><input type="text"  name="url"><p id="url"></p></td>
                </tr>
            
                     
                            

                </table>
                <input type="submit" value="Dar de alta publicación.">
                </form>
            <?php };
            
            $conn->close()?>
        </div>
    </div> 
    </body>

        
   
    <div style="right: 0px; width: 404px; position: absolute; bottom: -650px;" >
    <footer>
            <?php include 'footer.php' ?>
    </footer>
        
    </div>



</html>