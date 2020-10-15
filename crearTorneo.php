<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilopadel.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Dr+Sugiyama' rel='stylesheet' type='text/css'>
        <title>Página Web Padel las Salinas</title>
        
        <?PHP
        include ("funciones/funcionesDB.inc");// incluimos las funciones
        $error="";
        if(isset($_POST['enviar'])){
            $jugador1=$_POST['nombre_jugador1'];
            $jugador2=$_POST['nombre_jugador2'];
            $jugador3=$_POST['nombre_jugador3'];
            $jugador4=$_POST['nombre_jugador4'];
            
            // miramos cual es el último valor de cod_torneo de la tabla torneo 
            $sentencia2="SELECT cod_torneo FROM torneo ORDER BY cod_torneo  DESC LIMIT 1";
            $consulta=consulta($sentencia2);
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $cod_torneo =  $consulta->fetch();
            // Le sumamos 1 y creamos el nuevo torneo
            $cod_torneo[0]++;
            $sentencia="INSERT INTO torneo(cod_torneo, num_participante) VALUE(".$cod_torneo[0].",4)";
            insertar($sentencia);
            $fecha=date("Y-m-d");
            // Insertamos los jugadores del torneo
            insertarJugador($jugador1, $cod_torneo, $fecha);
            insertarJugador($jugador2, $cod_torneo, $fecha);
            insertarJugador($jugador3, $cod_torneo, $fecha);
            insertarJugador($jugador4, $cod_torneo, $fecha);
           
        }
        // Función que nos permite insertar a los jugadores
        function insertarJugador($jugador,$cod_torneo, $fecha){
            $consulta=consulta("SELECT cod_jugador from jugador WHERE nombre='".$jugador."'");
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $cod_jugador =  $consulta->fetch();

            $sentencia="INSERT  INTO participa  (cod_jugador, cod_torneo,fecha) VALUE (:cod_jugador, :cod_torneo, :fecha)";
            insertarPreparada($sentencia,array($cod_jugador[0], $cod_torneo[0], $fecha));
            sumarPartidoJugado($cod_jugador[0]);
        }
        // sumamos un partido al que ya tenía
        function sumarPartidoJugado($cod_jugador){
            $sentencia="SELECT p_jugados FROM jugador WHERE cod_jugador=".$cod_jugador."";
            $consulta=consulta($sentencia);
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $p_ganados =  $consulta->fetch();
            $p_ganados[0]++;
            $sentencia2="UPDATE jugador SET p_jugados=".$p_ganados[0]." WHERE cod_jugador=".$cod_jugador."";
            actualizar($sentencia2);
        }
        ?>
    </head>
    <body>
        <nav>
            <h1>Padel las Salinas</h1>
            <ul>
               <li><a href="index.php">Inicio</a></li>
               <li><a href="verTorneos.php" >Ver Torneos</a></li>
            </ul>
        </nav>
        
         <div id='login'>
             
             <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post' name="formulario">
                <fieldset >
                    <legend>Crear torneo</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    
                    <?PHP
                        // Dejo preparado el código para mas jugadores
//                    if(!empty($_POST['n_jugador'])){
                        
                    // cambiamos la siguiente instrucción por esta para cuando
                    // tengamos la opción de más jugadores $opcion=$_POST['n_jugador'];
                     //obtenemos los nombres de los jugadores
                             $sentencia = "SELECT nombre FROM jugador";
                            
                             //hacemos la consulta
                             $cod=consulta($sentencia);
                             while ($nombre = $cod->fetch()) {
                                    $nombre_jugadores[]=$nombre[0];
                                 } 
                             ?>    
                   <div class="campo">   
                   <label for="nombre_jugador1" >Jugador 1:</label>;
                    <?PHP
                       echo'<select name="nombre_jugador1">';
                       
                          for ($i=0;$i<count($nombre_jugadores);$i++) {
                                    echo '<option>'.$nombre_jugadores[$i].'</option>';
                                 } 
                       
                                 echo '</select></br>';
                                 
                           
                       ?>    
                     </div>   
                    <div class="campo">   
                   <label for="nombre_jugador2" >Jugador 2:</label>;
                    <?PHP
                       echo'<select name="nombre_jugador2">';
                       
                          for ($i=0;$i<count($nombre_jugadores);$i++) {
                                    echo '<option>'.$nombre_jugadores[$i].'</option>';
                                 } 
                       
                                 echo '</select></br>';
                                 
                           
                       ?>    
                     </div> 
                    <div class="campo">   
                   <label for="nombre_jugador3" >Jugador 3:</label>;
                    <?PHP
                       echo'<select name="nombre_jugador3">';
                       
                          for ($i=0;$i<count($nombre_jugadores);$i++) {
                                    echo '<option>'.$nombre_jugadores[$i].'</option>';
                                 } 
                       
                                 echo '</select></br>';
                                 
                           
                       ?>    
                     </div> 
                    
                    <div class="campo">   
                   <label for="nombre_jugador4" >Jugador 4:</label>;
                    <?PHP
                       echo'<select name="nombre_jugador4">';
                       
                          for ($i=0;$i<count($nombre_jugadores);$i++) {
                                    echo '<option>'.$nombre_jugadores[$i].'</option>';
                                 } 
                       
                                 echo '</select></br>';
                                 
                           
                       ?>    
                     </div> 
                    
                     <div class='campo'>
                         
                    
                      
                      <input type='submit' name='enviar' value='Crear jugadores' />
                    </div>
                           <?PHP  
                            
                       
//                    }else{
                    ?>
<!--                    <div class='campo'>
                        <label for='n_jugador' >Número de jugadores:</label>
                        <select id='n_jugador' name="n_jugador">
                         <?PHP
//                              echo '<option value="0">Número jugadores</option>';
//                              for ($i=4;$i<50;$i+=2){
//                                  echo '<option value='.$i.'>'.$i.'</option>';
//                              }
                          ?>
                        </select></br>
                       
                    </div>
                    
                    <div class='campo'>
                        <input type='submit' name='enviar' value='Enviar' />
                    </div>
                    <?PHP
                   
//                    }
                    ?>
                    -->
                </fieldset>
            </form>
         </div>
        
            
    </body>
</html>
