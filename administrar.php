<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilopadel.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Dr+Sugiyama' rel='stylesheet' type='text/css'>
        <title>Página Web Padel las Salinas</title>
        
        <?PHP
        include ("funciones/funcionesDB.inc");// incluimos las funciones
        $error="";
        // Función que nos perite borrar la partida 
        function eliminarPartida($cod_torneo){

            $sentencia='DELETE  FROM participa WHERE cod_torneo='.$cod_torneo;
            eliminar($sentencia);
        }
        // sumamos un partido al que ya tenía
        function sumarPartidoGanados($jugador){
            $sentencia='SELECT p_ganados FROM jugador WHERE nombre="'.$jugador.'"';
            $consulta=consulta($sentencia);
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $p_ganados =  $consulta->fetch();
            $p_ganados[0]++;
            $sentencia2='UPDATE jugador SET p_ganados='.$p_ganados[0].' WHERE nombre="'.$jugador.'"';
            actualizar($sentencia2);
        }
        // sumamos un partido al que ya tenía
        function sumarPartidoPerdidos($jugador){
            $sentencia='SELECT p_perdidos FROM jugador WHERE nombre="'.$jugador.'"';
            $consulta=consulta($sentencia);
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $p_perdidos =  $consulta->fetch();
            $p_perdidos[0]++;
            $sentencia2='UPDATE jugador SET p_perdidos='.$p_perdidos[0].' WHERE nombre="'.$jugador.'"';
            actualizar($sentencia2);
        }
        
        if(isset($_POST['enviar'])){
            $jugador1=$_POST['nombre_jugador1'];
            $jugador2=$_POST['nombre_jugador2'];
            $jugador3=$_POST['nombre_jugador3'];
            $jugador4=$_POST['nombre_jugador4'];
            $punto1=$_POST['puntos1'];
            $punto2=$_POST['puntos2'];
            $punto3=$_POST['puntos3'];
            $punto4=$_POST['puntos4'];
            $ctorneo=$_POST['ctorneo'];
            if($punto1=="Gana"){
                sumarPartidoGanados($jugador1);
            }else{
                sumarPartidoPerdidos($jugador1);
            }
            if($punto2=="Gana"){
                sumarPartidoGanados($jugador2);
            }else{
                sumarPartidoPerdidos($jugador2);
            }
            if($punto3=="Gana"){
                sumarPartidoGanados($jugador3);
            }else{
                sumarPartidoPerdidos($jugador3);
            }
            if($punto4=="Gana"){
                sumarPartidoGanados($jugador4);
            }else{
                sumarPartidoPerdidos($jugador4);
            }
            
            // Elimino la partida
            
            eliminarPartida($ctorneo);
            
          
       
     }
        ?>
</head>
    <body>
        <header>
        <nav>
            <h1>Padel las Salinas</h1>
            <ul>
               <li><a href="index.php">Inicio</a></li>
               <li><a href="agregarJugadores.php">Agregar Jugadores</a></li>
            </ul>
        </nav>
    </header>   
        <div class="secc" id="partida">
            <h2>Partidas en Curso</h2>

            
                
            <?PHP
           
             mostrarPartidas(guardarJugadoresTorneo());
           ?>
          <?PHP
           //Guardo el cod_jugador de cada torneo
          function guardarJugadoresTorneo(){
            // obtenemos de la tabla particiapa el cd_jugador y el cod_torneo
          $sentencia = "SELECT cod_torneo, cod_jugador FROM participa";
          //hacemos la consulta
          $lista=consulta($sentencia);
            while ($cod_torneo = $lista->fetch()) {
              $cod_torneo_cod_jugador[]=$cod_torneo;// array con cod_torneo y cod_jugador
              $cod_torneo_lista[]=$cod_torneo[0]; //obtengo el array con la lista de torneo
            }
            // pongo los torneos ordenando el indice y solo los valores unicos
            $cod_torneo_unicos= array_keys(array_count_values($cod_torneo_lista));  // torneos unicos 
            for ($i=0; $i < count($cod_torneo_unicos); $i++){ 
                for ($j=0; $j < count($cod_torneo_cod_jugador) ; $j++) { 
                  if ($cod_torneo_unicos[$i] == $cod_torneo_cod_jugador[$j][0]) {
                    $jugadoresTorneo[]=obtenerNombre($cod_torneo_cod_jugador[$j][1]);
                  }
                }
                //$indice=  intval($cod_torneo_unicos[$i]);
                //array bidimensional con el codigo de torneo y sus jugadores
                $torneoMasJugadores[$i]=array($cod_torneo_unicos[$i], $jugadoresTorneo[0], 
                    $jugadoresTorneo[1],$jugadoresTorneo[2],$jugadoresTorneo[3]);
                $jugadoresTorneo=null;
              }  
              return $torneoMasJugadores; // devuelvo el array bidimensional
              
          } 

          // función que nos permite obtener un nombre a través del cod_jugador
          function obtenerNombre($cod){
            $sentencia2 = 'SELECT  nombre FROM jugador where cod_jugador="'.$cod.'"';
            //hacemos la consulta
            $consulta=consulta($sentencia2);
            $consulta->setFetchMode(PDO::FETCH_NUM);
            $nombre=$consulta->fetch();
            return $nombre;
          }
          function mostrarPartidas($partida){
            for ($i=0; $i< count($partida); $i++){
                $columna="Código torneo: ".$partida[$i][0]
                        ." Jugador 1: ".$partida[$i][1][0]
                        ." Jugador 2: ".$partida[$i][2][0]
                        ." Jugador 3: ".$partida[$i][3][0]
                        ." Jugador 4: ".$partida[$i][4][0];
                echo '<p>'.$columna."</p>";
            }
          }
          
          
           ?>
        </div>
        
         <div class="secc" id="admin" >
             
             <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post' name="form_admin">
                <fieldset >
                    <legend>Crear torneo</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    
                    <?PHP
                      
                             $sentencia = "SELECT nombre FROM jugador";
                            
                             //hacemos la consulta
                             $cod=consulta($sentencia);
                             while ($nombre = $cod->fetch()) {
                                    $nombre_jugadores[]=$nombre[0];
                                 } 
                             ?>    
                   <div class="campo">   
                        <label for="nombre_jugador1" >Jugador:</label>
                    <?PHP
                      echo'<select name="nombre_jugador1">';
                       for ($i=0;$i<count($nombre_jugadores);$i++) {
                             echo '<option>'.$nombre_jugadores[$i].'</option>';
                       } 
                       echo '</select>';
                           
                       ?>  
                         <label for="puntos1" >Resultado: </label>
                         <select name="puntos1">
                             <option>Gana</option>
                             <option>Pierde</option>
                         </select>
                        </br>
                   </div>
                    <div class="campo">   
                        <label for="nombre_jugador2" >Jugador:</label>
                    <?PHP
                      echo'<select name="nombre_jugador2">';
                       for ($i=0;$i<count($nombre_jugadores);$i++) {
                             echo '<option>'.$nombre_jugadores[$i].'</option>';
                       } 
                       echo '</select>';
                           
                       ?>
                         <label for="puntos2" >Resultado</label>
                         <select name="puntos2">
                             <option>Gana</option>
                             <option>Pierde</option>
                         </select>
                        </br>
                    </div>
                        <div class="campo">   
                        <label for="nombre_jugador3" >Jugador:</label>
                    <?PHP
                      echo'<select name="nombre_jugador3">';
                       for ($i=0;$i<count($nombre_jugadores);$i++) {
                             echo '<option>'.$nombre_jugadores[$i].'</option>';
                       } 
                       echo '</select>';
                           
                       ?>  
                         <label for="puntos3" >Resultado</label>
                       <select name="puntos3">
                             <option>Gana</option>
                             <option>Pierde</option>
                         </select>
                        </br>
                        </div>
                      <div class="campo">   
                        <label for="nombre_jugador4" >Jugador:</label>
                    <?PHP
                      echo'<select name="nombre_jugador4">';
                       for ($i=0;$i<count($nombre_jugadores);$i++) {
                             echo '<option>'.$nombre_jugadores[$i].'</option>';
                       } 
                       echo '</select>';
                           
                       ?> 
                         <label for="puntos4" >Resultado</label>
                         <select name="puntos4">
                             <option>Gana</option>
                             <option>Pierde</option>
                         </select>
                        </br>
                      </div>
                        <div class="campo">   
                        <label for="ctorneo" >cod. torneo:</label>
                    <?PHP
                     $sentencia = "SELECT cod_torneo, cod_jugador FROM participa";
                      //hacemos la consulta
                      $lista=consulta($sentencia);
                        while ($cod_torneo = $lista->fetch()) {
                          $cod_torneo_lista[]=$cod_torneo[0]; //obtengo el array con la lista de torneo
                        }
                        $cod_torneo_unicos= array_keys(array_count_values($cod_torneo_lista));  // torneos unicos 
                      echo'<select name="ctorneo">';
                       for ($i=0;$i<count($cod_torneo_unicos);$i++) {
                             echo '<option>'.$cod_torneo_unicos[$i].'</option>';
                       } 
                       echo '</select>';
                           
                       ?>  
                        </br>
                   </div>
                    
                   
                    
                     <div class='campo'>
                      
                      <input type='submit' name='enviar' value='Enviar puntos' />
                    </div>
                   
                </fieldset>
            </form>
         </div>
        
            
    </body>
</html>


