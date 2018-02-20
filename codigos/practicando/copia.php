<?php



                $dbhost = 'localhost';
                $db = 'proyecto';
                $db_username = 'root';
                $db_pass = '';
 $myConnection= mysqli_connect("$dbhost","$db_username","$db_pass", "$db") or die ("could not connect to mysql");   
     
// Obtener listado de tablas
$tablas = array();
$result = mysqli_query( $myConnection,'SHOW TABLES');
while ($row = mysqli_fetch_row($result)){
	$tablas[] = $row[0];
}
// Salvar cada tabla
$salida = '';
foreach ($tablas as $tab) {
$result = mysqli_query( $myConnection,'SELECT * FROM '.$tab);
$num = mysqli_num_fields($result);
$salida .= 'DROP TABLE '.$tab.';';
$row2 = mysqli_fetch_row(mysqli_query( $myConnection,'SHOW CREATE TABLE '.$tab));
$salida .= "\n\n".$row2[1].";\n\n"; // row2[0]=nombre de tabla
while ($row = mysqli_fetch_row($result)) {
$salida .= 'INSERT INTO '.$tab.' VALUES(';
for ($j=0; $j<$num; $j++) {
$row[$j] = addslashes($row[$j]);
$row[$j] = preg_replace("/\n/","\\n",$row[$j]);
if (isset($row[$j]))
$salida .= '"'.$row[$j].'"';
else
$salida .= '""';
if ($j < ($num-1)) $salida .= ',';
}
$salida .= ");\n";
}
$salida .= "\n\n\n";
}
/*
echo "$salida";
exec('b.sql');

header( "Content-Disposition: attachment; filename=".$dumpfile."");
header("Content-type: application/force-download");
@readfile($dumpfile);
*/
$nombre_archivo = "BD_RESTORE.sql"; 
 
    if(file_exists($nombre_archivo))
    {
        $mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
 
    else
    {
        $mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, $salida))
        {
            echo "Se ha ejecutado correctamente la copia de su Base de datos, se ha creado en su directorio ~investiga/BD_RESTORE.sql";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }
 
        fclose($archivo);
    }

?>
