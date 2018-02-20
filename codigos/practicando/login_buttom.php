       <div class="logout">
            <?php 

                if(isset($_SESSION['username'])){
                    if($_SESSION['type']=='admin' && $_SESSION['type']=='profesor'){
                        echo '       
                            <form align="right" name="formlogout" method="post" action="logout.php">
                                <label>
                                    <input name="submitlogout" type="submit" id="submitlogout" value="Cerrar sesión.">
                                </label>
                            </form>
                        ';
                    }
                }
                    else{
                        echo '
                        <form align="right" name="formlogin" method="post" action="adminlogin.php">
                                <label>
                                    <input name="submitlogin" type="submit" id="submmitlogin" value="Iniciar sesión.">
                                </label>
                        </form>            
                        ';
                    }
                
            ?> 
        </div>                    

