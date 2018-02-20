<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Peticion_asistencia_sesiones</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <?php include 'inicioSesionMySQL.php';?>
        <script src="javascript/ejercicio/ejercicio.js"></script>
        <script>
          
        function changeFormatDate(){
    
 /*Debido a que la función jQuery utilizada para mostrar un calendario cuando el usuario pulsa en el campo date de la tabla utiliza
 * un formato dd/mm/yyyy que es el especificado en los requisitios y la base de datos utiliza un formato yyyy-mm-dd entonces
 * si la fecha introducida es correcta tenemos que pasar los datos de la fecha al formato aceptado por la base de datos.
 */
               
            /*Pasamos de dd/mm/yyyy a yyyy-mm-dd  y actualizamos la fecha*/
             var dateString = document.getElementById("fecha").innerHTML;
    
            var parts = dateString.split("-");
            var year = parts[0];
            var month =parts[1];
            var day = parts[2];

            var fecha=String(day) + "/" + String(month) + "/" + String(year);
    
            document.getElementById("fecha").innerHTML=fecha;
    
    }

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
                                <a href=modulovisualizacion.php>Visualizar</a>
                                <a class="menu_lateral_selected" href=sesionesdisponibles.php>Sesiones disponibles</a>
                                <a href=consultarposicion.php>Consultar posicion</a>
                                <a href=eliminarcita.php>Eliminar cita</a>
                            </ul>
                    </div>
                <div>
                    <?php include 'login_buttom.php' ?>
                </div>
                </div>
            <div class='container-display'>
                <?php

                /* Si nos llegan datos POST significa que vamos a insertar una nueva petición */
        if (!empty($_POST['peticion']) && !empty($_POST['dni']) && !empty($_POST['email'])){
            
            /* Comprobamos si la fecha y la hora a la que vamos a realizar la petición son correctas respecto a la hora de fin de aceptación de peticiones
             * de la sesión y respecto a la fecha de la sesión.
             */

                $sql = "SELECT COUNT(codigoSesion) as sesiondisponible  FROM sesionevaluacion2 WHERE codigoSesion= \"" . $_POST['peticion'] . "\" AND fecha=CURDATE() AND hfin>curtime();";
                $result = $conn->query($sql);
                $row=$result->fetch_assoc();
                $inserccion=false;
                
                if($row['sesiondisponible']>0){  
                        //Si la fecha de la sesión a la que vamos a insertar la petición es la actual y la hora actual es menor que la hora limite insertamos la petición.
                        $inserccion=true;
                }    
                else{ //Probamos si fecha de la sesión en la que estamos insertando la petición no es la actual
                
                        $sql = "SELECT COUNT(codigoSesion) as sesiondisponible  FROM sesionevaluacion2 WHERE codigoSesion= \"" . $_POST['peticion'] . "\" AND fecha>CURDATE();";
                        $result = $conn->query($sql); //Es menor la fecha actual que la fecha de la sesión?
                        $row=$result->fetch_assoc();
                        if($row['sesiondisponible']>0){
                    
                            //Si la fecha actual es menor que la fecha de la sesión entonces autorizamos que se inserte la sesión.
                            $inserccion=true;
                        }
                        else{
                             //Si la fecha actual es mayor que la de la sesión 
                             echo ' <p id="mensajec">La sesión está cerrada. La fecha ha pasado. <a href="sesionesdisponibles.php">Regresar a sesiones disponibles</a></p></p>';

                        }
                        
                    
                    }
                if($inserccion){ 
                    
                 /*Si los astros se han alineado y todas las condiciones, fechas, horas y demas cosas se cumplen para poder realizar la insercción
                 * entonces insertamos esta en la base de datos
                 */
                    $sql = "SELECT codigoSesion  FROM sesionevaluacion2 WHERE codigoSesion= \"" . $_POST['peticion'] . "\";";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        $sql = "SELECT MAX(codalumno) as numeroPeticiones FROM colapeticiones;";
                        $result = $conn->query($sql);
                    
                        $cod1=substr($_POST['dni'], 6, 3);
                        $cod2=substr($_POST['email'],0,3);
                        if ($result->num_rows > 0 ) {
                            $row = $result->fetch_assoc();
                            $codalumno=$row["numeroPeticiones"]+1;
                        
                            $codpeticion=$cod1.$codalumno.$cod2;
                    
                            $sql = "INSERT INTO colapeticiones (codalumno, codpeticion, codsesion, dni, email, prioridad ) VALUES (\"" . $codalumno . "\" "
                                . ", \"" . $codpeticion . "\" , \"" . $_POST['peticion'] . "\" , \"" . $_POST['dni'] . "\" , \"" . $_POST['email'] . "\" , \"" . $codalumno ."\" );" ;
                    
                            $result = $conn->query($sql);
                            if ($result){
                                echo '<h1> Código de asistencia a sesiones</h1>'
                                . '<p id="mensajec">Código de asistencia: ' . $codpeticion . '</p>'
                                . '<p id="mensajec">Volver a la ventana de <a href="sesionesdisponibles.php">sesiones disponibles</a></p>';
                            }
                        
                            else { echo ' <p id="mensajec">Error realizar la petición por favor <a href="sesionesdisponibles.php">vuelva a intentarlo</a></p>';}
                    }
                }
                else{ 
                    echo ' <p id="mensajec">Código de sesión inválido. . <a href="sesionesdisponibles.php">Vuelva a intentarlo</a></p>';
                }
                    
                }

            

            }
                /*Si no recibimos datos por POST significa que vamos a imprmir el formulario de petición de datos para realizar la petición de asistencia la sesión.
                 * sesionesdisponibles.php nos tiene que haber enviado el código de la sesión a la que vamos a realizar la petición asi que lo buscamos entre
                 *  los mensajes post POST
                 */
                else{
                    $regex = "@cod*@";
                    $vars = array();
                    $x=0;
                    foreach($_POST as $name=>$value) {
                        if(preg_match($regex, $name)) {
                            $x=1;
                            $cropped= str_replace('cod','',$name);
                            $codsesion= $cropped;
                        }
                    }
                    if($x==1){
                        echo '
                            <h1> Página de petición de asistencia a sesiones</h1>
                            <table>
                            <tr>
                            <th>Código sesión</th>
                            <th>Fecha Inicio</th>
                            <th>Hora inicio</th>
                            <th>Hora fin</th>
                            <th>Nº Despacho</th>
                            <th>Asignatura</th>
                            <th>Curso</th>
                        </tr>
                        ';
        
        
        $sql = "SELECT fecha, curso, hinicio, hfin, ndespacho, asignatura, codigoSesion  FROM sesionevaluacion2 WHERE codigoSesion= \"" . $codsesion . "\";";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<tr>';          
                echo ' <td>' . $row["codigoSesion"]. '</td>';
                echo ' <td><p id= "fecha">' . $row["fecha"]. '</p></td>';                
                echo ' <td>' . $row["hinicio"]. '</td>';
                echo ' <td>' . $row["hfin"]. '</td>';
                echo ' <td>' . $row["ndespacho"]. '</td>';
                echo ' <td>' . $row["asignatura"]. '</td>';
                echo ' <td>' . $row["curso"]. '</td>';
                echo '</tr>';
        }
                
                echo '<script>
                changeFormatDate();
                </script>
                </table>
                
                <form  name="fpeticion" action=  ' . htmlspecialchars($_SERVER['PHP_SELF']) . '  method="post" onsubmit="return comprobacionDatos(&quot;fpeticion&quot;)">
                    <table>
                        <input type="hidden" name="peticion" value="' . $codsesion .  ' ">
                        <tr>
                            <td>Introduzca su DNI: <input type="text"  name="dni"><p id="dni"></p></td>
                        </tr>
                        <tr>
                            <td>Introduzca su email: <input type="email"  name="email"><p id="email"></p></td>
                        </tr>                    
                    </table>
                    <input type="submit" value="Realizar petición.">
                </form>';
                    }
                    else{
                        echo ''
                        . '<p>Código de sesión introducido inexistente. Por favor consulte : <a href="sesionesdisponibles.php">sesiones disponibles</a></p>  ' ;
                    }                   
                }
                $conn->close();
        ?>
            </div>
        </div>
        <footer>
            <?php include 'footer.php' ?>
        </footer>
    </body>
</html>
