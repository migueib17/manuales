<?php

require('config.php');

$query_num_services =  mysql_query("SELECT * FROM services WHERE status=1", $conexion);
$num_total_registros = mysql_num_rows($query_num_services);

//Si hay registros
 if ($num_total_registros > 0) {
    //numero de registros por página
    $rowsPerPage = 3;

    //por defecto mostramos la página 1
    $pageNum = 1;

    // si $_GET['page'] esta definido, usamos este número de página
    if(isset($_GET['page'])) {
        sleep(1);
        $pageNum = $_GET['page'];
    }

    //contando el desplazamiento
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);

    $query_services = mysql_query("SELECT service_id, title, description, rating FROM services WHERE status=1 ORDER BY date_added DESC LIMIT $offset, $rowsPerPage", $conexion);
    while ($row_services = mysql_fetch_array($query_services)) {
       //Mostramos los sevicios
       ...
    }
...
?>


