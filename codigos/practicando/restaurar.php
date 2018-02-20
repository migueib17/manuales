<?php 
include ("funcionabilidad.php"); 

$dbhost = 'localhost';
                $db = 'proyecto';
                $db_username = 'root';
                $db_pass = '';
 $myConnection= mysqli_connect("$dbhost","$db_username","$db_pass", "$db") or die ("could not connect to mysql");   


echo'<title>Restore & backup</title>'; 
if (!isset ($_FILES["ficheroDeCopia"])) 
{ 
$contenidoDeFormulario="<form action='restaurar.php' method='post' enctype='multipart/form-data' name='formularioDeRestauracion'"; 
$contenidoDeFormulario.="id='formularioDeRestauracion'>\n"; 
$contenidoDeFormulario.="<table width='360' border='0' align='center' class='normal' cellspacing='7'>\n"; 
$contenidoDeFormulario.="<tr>\n"; 
$contenidoDeFormulario.="<td colspan='4' align=center>Indique el origen del archivo de copia: </td>\n"; 
$contenidoDeFormulario.="</tr>\n"; 
$contenidoDeFormulario.="<td colspan='2' align=center><input type='file' name='ficheroDeCopia' id='ficheroDeCopia'"; 
$contenidoDeFormulario.="size='30'></td>\n"; 
$contenidoDeFormulario.="<tr>\n"; 
$contenidoDeFormulario.="<td colspan='3' align='center'><input name='envio' type='submit' "; 
$contenidoDeFormulario.="id='envio' value='[ Aceptar ]'></td>\n"; 
$contenidoDeFormulario.="</tr>\n"; 
$contenidoDeFormulario.="</tbody>\n"; 
$contenidoDeFormulario.="</table>\n"; 
$contenidoDeFormulario.="</form>\n"; 
echo ($contenidoDeFormulario); 
} 
 else  
 { 
     
 $f=$_FILES["ficheroDeCopia"]["tmp_name"]; 
 $destino="./BD_RESTORE2.sql"; 
     
if (!move_uploaded_file ($f, $destino)) 
{ 
$mensaje='EL proceso ha fallado'; 
echo $mensaje; 
} 

$f="BD_RESTORE2.sql"; 

mysqli_query($myConnection,'SET FOREIGN_KEY_CHECKS=0');
$error = '';
$sql = file_get_contents($f);
$queries = explode(';',$sql);
foreach ($queries as $q) {
if (!mysqli_query($myConnection,$q))
$error .= mysqli_error($myConnection);


}


if (mysqli_query($myConnection,'SET FOREIGN_KEY_CHECKS=1')) {


    $mensaje2="La copia de seguridad se ha restaurado correctamente.";  
    $cabecera2="COPIA DE SEGURIDAD RESTAURADA"; 
    echo $mensaje2; 
    echo "<meta http-equiv='Refresh' content='3;url=acrearadministrador.php'>"; 

}else{

        $mensaje="ERROR. La copia de seguridad no se ha restaurado."; 
        $cabecera="COPIA DE SEGURIDAD NO RESTAURADA"; 
        echo $mensaje; 
        echo "<meta http-equiv='Refresh' content='3;url=acrearadministrador.php'>"; 


}

     
} 



?>
