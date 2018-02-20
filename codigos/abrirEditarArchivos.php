<?php
$myfile = fopen("file.txt", "w");
}
//Outputs "Value is: John"


/*
r : Abre el archivo solo para lectura. 
w : abre el archivo solo para escritura. Borra el contenido del archivo o crea un nuevo archivo si no existe. 
a : Abre el archivo solo para escritura. 
x : crea un nuevo archivo para solo escritura. 
r + : Abre el archivo para lectura / escritura. 
w +: Abre el archivo para lectura / escritura. Borra el contenido del archivo o crea un nuevo archivo si no existe. 
a + : Abre el archivo para lectura / escritura. Crea un nuevo archivo si el archivo no existe 
x + : crea un nuevo archivo para lectura / escritura. 
*/

?>

<?php 
$myfile = fopen ("nombres.txt", "w"); 

$txt = "John \n"; 
fwrite($myfile, $txt); 
$txt = "David \n"; 
fwrite($myfile, $txt); 

fclose($myfile); 

/* El archivo contiene: 
John 
David 


La función fclose() cierra un archivo abierto y devuelve TRUE en caso de éxito o FALSE en caso de error. 
*/ 
?>

<?php
//Agregar a un archivo

$myFile = "test.txt";
$fh = fopen($myFile, 'a');
fwrite($fh, "Some text");
fclose($fh);
?>

<?php
if(isset($_POST['text'])) {
  $name = $_POST['text'];
  $handle = fopen('names.txt', 'a');
  fwrite($handle, $name."\n");
  fclose($handle); 
}
?>
<form method="post">
  Name: <input type="text" name="text" /> 
  <input type="submit" name="submit" />
</form>


<?php
//Leer un archivo
$read = file('names.txt');
foreach ($read as $line) {
  echo $line .", ";
}

?>

<?php
//Leer un archivo
$read = file('names.txt');
$count = count($read);
$i = 1;
foreach ($read as $line) {
  echo $line;
  if($i < $count) {
    echo ', ';
  }
  $i++;
}

?>
