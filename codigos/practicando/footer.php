
                            <nav>
                          <ul>
                                <li><a>
                                	<div id="ugr"> <p>UGR</p></div>
                                	</a>
                                </li>
                                <li><a>
                                	<div id="tec"> <p>TECNOLOG&iacuteAS WEB</p></div>
                                	</a>
                                  </li>     

                                <li><a href="autoria.php">
                                 	<div id="autorias"> <p>AUTOR&iacuteAS</p></div>
                                	</a>
                                </li>

                                <li><a href="documentacion.php">
                                 	<div id="info"> <p>Documentación</p></div>
                                 	</a>
                                </li>
                                
                                <li><a href="copy.php">
                                	<div id="copy"> <p>Copyright</p></div>
                                	</a>
                                </li>
    <?php  
                                  if(isset($_SESSION['username'])){
                                if($_SESSION['type']=='admin'){
    ?> 

                                </li> 
                                  <li><a href="verlog.php">
                                  <div id="log"> <p>Ver LOG</p></div>
                                  </a>
                                </li> 
                                <li><a href="restaurar.php">
                                  <div id="restaurar"> <p>Restaurar BD</p></div>
                                  </a>
                                </li>  
                                </li>     
                                <li><a href="copia.php">
                                  <div id="copia"> <p>Copia BD</p></div>
                                  </a>
<?php 
            }
          }

 ?>

                          </ul>
                    </nav>



