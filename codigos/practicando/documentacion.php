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
            <h1> Documentación de la página </h1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("button").click(function(){
        $.ajax({url: "ajax.txt", success: function(result){
            $("#div1").html(result);
        }});
    });
});
</script>
</head>
<body>





<strong>Uso:</strong> Para entrar como administrador con todos los privilegios de gestión exite el usuario:<strong>admin</strong> con contraseña: <strong>admin</strong>


<h3>Manual de usuario</h3>

 la aplicación está destinada a gestionar las tareas necesiarias de un grupo de investigación . Etas tareas girarán entorno a la <em>gestion de los miembros del grupo de investigación, sus proyectos y sus publicaciones.</em>

Se contempla la necesidad de acceder a la tareas según los privilegios del usuario, permitiendo así el uso y mantenimiento de la página y evitando intrusismo y errores. Estos niveles de acceso serán: visitante, miembro y administrador.

<strong>Seccion vistantes:</strong> Esta sección e abierta al publici en general por lo que no hay necesidad de identificarse en la página para realizar las  tareas que en ella se acceden.
Las tareas de esta sección son las siguientes:
<ul>
    <li> Listar miembros: Esta tarea permite listar todos los miebros que pertenecen al grupo de investigación dando los más relebantes de sus datos personales a la vez que da acceso a toda la inforación de cada uno de los miembros</il>
    <li> Listar proyectos: De la misma fora que en la tarea <em> listar iembros </em> podemos listar todos los proyectos del grupo viendo sus datos más relevantes o podemos acceder a toda la información.
    <li> Listar publicaciones: Esta tarea proporciona un litado de las publicaciones del grupo de investigación y a que proyecto van ligadas.
</ul>

La sección de <em>visitantes<em> da acceso a un menú en el pie de página(footer) donde se pueden encontrar las siguientes tareas:
<ul>
    <li>Autoria: Datos de los miembros del equipo de desarrollo.</li>
    <li> Documentación: Información sobre el uso y estructura de la página web </li>
    <li>copyrigth: Define la ley de propiedad intelectual </li>
</ul>


<strong>Seccion profesor-miembro:</strong> El profesor-miembro posee mayor acceso que un visitante foraneo al grupo y por lo tanto posee tareas específicas. Estas tareas son:
<ul>
   <li> Añadir proyecto: Esta tarea permite al miembro crear un proyecto completo. </li>
    <li> Gestionar proyecto: Esta tarea permite gestionar lo proyectos del grupo de investigación seleccionando de un listado la tarea que se quiere aplicar sobre un determinado objeto. Las tareas disponibles son: </il>
            <li> Modificar proyecto: Nos devuelve los datos de un proyecto para poder modificarlo. </li>
            <li> Eliminar proyecto: Nos permite eliminar el proyecto seleccionado. </li>



    <li> Añadir publicación: Esta tarea permite al miembro crear una publicación ligada a un proyecto. </li>
    <li> Gestionar publicar: Esta tarea permite gestionar las publicaciones de un proyecto seleccionando de un listado, la tarea que se quiere aplicar sobre un determinado objeto. Las tareas disponibles son: </li>
            <li> Modificar publicación: Nos devuelve los datos de una publicación para poder modificarla. </li>
            <li> Eliminar publicación: Nos permite eliminar la publicación seleccionada. </li>


    <li>Gestionar sus datos de acceso de usuario: Un miembro podrá cambiar sus datos de usuario(nombre, correo, contraseña). El resto de datos estarán protegidos y solo serán accesibles por el administrador.</li>

</ul>
La sección de <em>usuarios-miembros<em> da acceso a un menú en el pie de página(footer), donde se pueden encontrar las siguientes tareas:
<ul>
    <li>Autoria: Datos de los miembros del equipo de desarrollo.</li>
    <li> Documentación: Información sobre el uso y estructura de la página web </li>
    <li>copyrigth: Define la ley de propiedad intelectual </li>
</ul>








<strong>Seccion Administrador:</strong> El adminitrador tendrá los privilegios relacionados con la gestión directa con las bases de datos y por tanto será el encargado de crear modificar y eliminar todos los elementos relacionados con la página(miembros, administradores, proyectos, publicaciones...). También serán tareas designadas al administrador todas aquellas que esten relacionadas con el mantenimiento de los datos, como hacer copias de seguridad restituir bases de datos, seguimientos de errores, etc..
Las tareas de esta sección son las siguientes:
<ul>
    <li>Dar de alta administrador : Nos permite crear un usuario con permisos de administración<\li>
    <li>Gestión de administradores: Nos permite acceder, mediante un listado de todos los usuarios, a las funciones de administración que en este caso son:<\li>
        <li> Modificar administrador: Nos devuelve los datos de un adinistrador para poder modificarlo. </li>
        <li> Eliminar adminitrador: Nos permite eliminar el adinistrador seleccionado. <li/>
    


  <li> Dar de alta miembros-usuario: Esta tarea permite dar de alta un usuario en la base de datos del sistema  </li>
    <li> Gestion de usuarios- miembros: Esta tarea permite crear un usuario del sistema. Partiendo de esta tarea tendremos acceso a toda la gestión de los usuarios  </il>
            <li> Modificar usuario: Nos devuelve los datos de un usuario para poder modificarlo. </li>
            <li> Eliminar usuario: Nos permite eliminar el usuario seleccionado. </li>
    <li> Dar de alta miembro-usuario: Esta tarea permite al administrador crear un nuevo usuario de la página </li>



    <li> Dar de alta miembros: Esta tarea permite dar de alta un miembro en la base de datos del sistema  </li>

    <li> Gestion de miembros: Esta tarea listar todos los usuarios del sistema. Partiendo de esta tarea tendremos acceso a toda la gestión de los miembro  </li>
            <li> Modificar miembro: Nos devuelve los datos de un miembro para poder  modificarlo. </li>
            <li> Eliminar miembro: Nos permite eliminar el usuario seleccionado. <li/>
    



    <li> Añadir proyecto: Esta tarea permite al administrador crear un proyecto completo. </li>
    <li> Gestionar proyecto: Esta tarea permite gestionar lo proyectos del grupo de investigación seleccionando de un listado la tarea que se quiere aplicar sobre un determinado objeto. Las tareas disponibles son: </il>
            <li> Modificar proyecto: Nos devuelve los datos de un proyecto para poder modificarlo. </li>
            <li> Eliminar proyecto: Nos permite eliminar el proyecto seleccionado. <li/>



<li> Añadir publicación: Esta tarea permite al administrador crear una publicación ligada a un proyecto. </li>
    <li> Gestionar publicar: Esta tarea permite gestionar las publicaciones de un proyecto seleccionando de un listado, la tarea que se quiere aplicar sobre un determinado objeto. Las tareas disponibles son: </li>
            <li> Modificar publicación: Nos devuelve los datos de una publicación para poder modificarla. </li>
            <li> Eliminar publicación: Nos permite eliminar la publicación seleccionada. </li>   
    
</ul>


La sección del <em>administrador<em> da acceso a un menú en el pie de página(footer) donde se pueden encontrar las siguientes tareas:
<ul>
    <li>Autoria: Datos de los miembros del equipo de desarrollo.</li>
    <li> Documentación: Información sobre el uso y estructura de la página web </li>
    <li>copyrigth: Define la ley de propiedad intelectual </li>
    <li> Crear una copia derespaldo: Permite crear una copia actualizada de la basede datos. </li>
    <li> Restaurar la base de datos: Perite  sustituir la baede datos por una copia de respaldo elegida porel administrador </li>
    <li> Log del sistema: Da acceso al log del sistema </li>

</ul>



<h3>Base de datos</h3>

Se propone el siguiente modelo de base de datos.


Se contemplan como entidades:
    <ul>
        <li>Losmiembros del grupo de  investigación </li>
        <li>Los proyecto del grupo de investigación </li>
        <li>Las publicaiones sobre los proyectos del grupo de investigación</li>
    </ul>
Sobre este último ítem se aplica una generalización permitiendonos crear tres subclases de publicaciones
    <ul>    
        <li>Las artículos de revistas</li>
        <li>Los capitulos</li>
        <li>Los libros</li>
        <li>Conerencias </li>
    </ul>   

Cada una de las subclases de publicaciones tendrá sus própias característica pero compartiran, mediante un atributo que identifica a la publicación  a la que pertenecen, las características de publicación.

A continuación se muestra un diagrama de entidad relación para el modelo propuesto.

<img src="imagenes/er.png"/>


<h3>Sitemas de archivos</h3>

La organización del sistema de archivos responde a la siguiente jerarquía
raiz:<br><br>
<img src="imagenes/arch.png"/ width="330px" height="380px"><br><br><br>
    archivos .php
    javascript
        jquery
            archivos .jquery
        ejercicios
            archivos .js destinados a las validaciones de los formularios
    imagenes
        imagenes usadas en la página
    css
        archivos .css destinados al estilo de la página
    log
        archivos .txt destinados al seguimiento del funcionamiento del sistema



<h3>Maquetación de la Página</h3>

Para la maquetación de la página hemos utilizado un diseño de cajas sencillo. Proporcionamos un cabecera con la opción de acceso para aquellos usuarios que no hayan accedido mediante credenciales, y una cabecera para aquellos que sí lo hayan hecho.
De la misma forma, el pie de página se mostrará en el mismo lugar pero con diferente contenido, dependiendo del tipo de usuario que en ese momento este utilizando la página.
Mediante estos dos elementos quedará definido la altura de la página.
Ofrecemos un menú de tareas diseñado como un elemento absoluto con el fin de dejar todas las tareas visibles durante el desplazamiento vertical por la página.
Por último, la parte central de la página queda reservada para la visualización de contenidos: listados,  formularios...


<div id="div1"><h3> Tecnologías utilizadas </h3></div>

<button>AJAX CONTENIDO DINÁMICO</button>


<h3> Responsive </h3>
Se a añadido a la página la funcionbilidad de adaptacion a la pantalla para los tamaños siguientes:
<ul>
<li> Moviles: 480px de anchura (portrait).</li>
<li> Tablets: 768px-1024px.</li>
<li> Desktop: mínimo 1024px. </li>
</ul>
Lo hemos realizado incluyendo una funcion @media para cada uno de los tres tamaños indicados.


 
            </div>        

        
        </div>
    </div>
    <div style="right: 0px; width: 404px; position: absolute; bottom: -3250px;" >
        <footer>
            <?php include 'footer.php' ?>
        </footer>
        </div>
    </body>
</html>
