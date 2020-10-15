<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilopadel.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Dr+Sugiyama' rel='stylesheet' type='text/css'>
        <title>Página Web Padel las Salinas</title>
        </head>
        <body>
            <header>
            <nav>
                <h1>Padel las Salinas</h1>
                <ul>
                   <li><a href="index.php">Inicio</a></li>
                </ul>
            </nav>
        </header>   
            <div class="secc" id="partida">
                <h2>Partidas en Curso</h2>



                <?PHP
                include ("funciones/funcionesDB.inc");// incluimos las funciones
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
                    
    </body>
</html>

