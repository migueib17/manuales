<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>index</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>
        <div class="container-body">
            <?php
                    include 'inicioSesionMySQL.php';
            ?>
            <div class='container-cabecera'>
                <?php include 'cabecera.php' ?>
            </div>
            
            <?php header("Location: modulovisualizacion.php");?>

            <div class='container-cuerpo'>
                <div class='container-menu' style="visibility: hidden">
                    <?php include 'menulateral.php'; ?>
                </div>
                <div class='container-display'>
                    <div id="menu_login">
                        <?php include 'login.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>