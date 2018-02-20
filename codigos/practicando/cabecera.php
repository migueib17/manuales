

<!DOCTYPE html>
<html>


    <div>
        <a href="modulovisualizacion.php">
            <img src="imagenes/emiliosantiago.png" alt="emiliosantiago" id="emiliosantiago">
        </a>
        <img src="imagenes/departamento.png" alt="departamento" id="departamento">
        
            <img src="imagenes/logo.jpg" alt="logo"id="logo">
        </a>
    </div>

    <div>
                <div>
                    <div class="menu_login2">
                         <?php  
        /*
         * Mostramos un formulario con dos inputs tipo texto para la introducción del nombre de usuario y contraseña
         */

        
        ?>
        
<?php 


            if (isset($_SESSION['username'])) {

                
?> 
            <p>HOLA <?php echo $_SESSION['username'];?></p>
            
<?php
            echo '       
                            <form align="right" name="formlogout" method="post" action="logout.php">
                                <label>
                                    <input name="submitlogout" type="submit" id="submitlogout" value="Cerrar sesión.">
                                </label>
                            </form>
                        ';
            
  ?>
<?php 

        
        }

        else{
            session_start()
?>

        <form  name="fcrearsesion" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  
            ?>" onsubmit="return comprobacionDatos()" method="post">

                    <p>Usuario:<input type="text" name="username"></p><p></p>
                    <p>Contraseña:<input type="password"  name="password"><p></p>

<?php 
        echo '
                        <form align="right" name="formlogin" method="post" action="">
                                <label>
                                    <input name="submitlogin" type="submit" id="submmitlogin" value="Iniciar sesión.">
                                </label>
                        </form>            
                        ';

 ?>
            
        </form>


<?php

        }

 ?>


        <?php

        error_reporting(E_ERROR);
        /*
         * Una vez que se ha introducido el usuario y la contraseña en los inputs y tras habre pulsado Login
         */
        if (!empty($_POST['username'])  && !empty($_POST['password'])) { 

            $sql = "SELECT  username, password, type FROM usuarios WHERE username= \"" . $_POST["username"] ."\" AND password= \"" . md5($_POST["password"]) . "\";";

            $result = $GLOBALS['conn']->query($sql);
            if ($result->num_rows > 0) {
                $row=$result->fetch_assoc();
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["type"] = $row['type'];
                if($row['type']=='admin'){

                           


                                    header("Location: agestionadministradores.php");
                }
                            elseif($row['type']=='profesor'){

                                 

                                            
                                header("Location: pgestionproyectos.php");
                            }
                exit();
            }
            else {

                $sql = "SELECT username FROM usuarios  WHERE username= \"" . $_POST["username"] ."\";";
                $result = $GLOBALS['conn']->query($sql);
                if ($result->num_rows > 0) {
                     echo "<p> Contraseña incorrecta.</p><br>";
                }
                else{
                    echo "<p> Usuario inexistente.</p><br>";
                }   
            }
            $conn->close();
               }
        ?>
                    </div>
                </div>
            </div>
</html>