<!DOCTYPE html>
<?php
    // Recuperamos la información de la sesión
    session_start();
    
    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        $usuario="Invitado";
    }else{
        $usuario=$_SESSION['usuario'];
    }
    
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilopadel.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Dr+Sugiyama' rel='stylesheet' type='text/css'>
        <title>Página Web Padel las Salinas</title>
        <?PHP
        include ("funciones/funcionesDB.inc");// incluimos las funciones
        ?>
   
    </head>
    <body>
        <header>
        <nav id="inicio">
            <h1>Padel las Salinas</h1>
            <ul>
               <li><a href="#noticias">Noticias</a></li>
               <li><a href="#participa" >Participa</a></li>
               <li><a href="#ranking">Ranking</a></li>
               <li><a href="#fotos">Fotos</a></li>
               <li><a href="login.php">Login</a></li>
            </ul>
            <p id="logueo">Usuario: <?php echo $usuario; ?></p>
        </nav>
        </header>
        <div id="divfondo">
       
            
            <div class="secc" >
             
                <h2>Bienvenidos a la Web de Padel las Salinas</h2>
              <h3>Dirección</h3> 
              <p id="presentacion">Padel Las Salinas es un complejo deportivo formado por 3 pistas de padel cubiertas y un bar, localizado en el Poligono Las Salinas.</p>
              
              <div id="imgInicio"></div> 
            </div>
            
           <div class="secc" id="noticias">
               
                <h2> Noticias</h2>
                <?PHP
                // miro si existe el archivo xml
                    if (file_exists('xml/noticias.xml')) {
                        //si existe lo guardo en un array 
                        $xml = simplexml_load_file('xml/noticias.xml');
                        //muestro las noticias
                        for ($i=0;$i<count($xml);$i++){
                            echo '<h3>'.$xml->noticia[$i]->titulo.'</h3>';
                            echo '<p>'.$xml->noticia[$i]->contenido.'</p>';
                            echo '<image src="'.$xml->noticia[$i]->imagen.'"</image>';
                        }
                    } else {
                         exit('Error al cargar las noticias.');
                    }
                    
                ?>
                
            </div>
            <div class="secc" id="participa">
                <h2>Participa</h2>
                <?PHP
                // Miramos si el usuario está logueado
                // Si no está mostramos un texto diciendo que puedes hacer si estás logueado
                if($usuario=="Invitado"){
                    echo '<p>En esta sección los usuarios que estén registrados tendran acceso '
                    . 'a la creación de torneos en los cuales podrán conseguir puntos para '
                            . 'escalar puestos en el ranking de nuestras pistas</p>';
                    echo '<p>Esperamos vuestra participación</p>';
                    echo '<p>Si no estás registrado hazlo en nuestras pistas</p>';
                }else{
                    // Si es un usuario registrado podrá crear torneos
                    ?>
                <ul>
                    <li><a href="crearTorneo.php" >Crear Torneos</a></li>
                    <?PHP
                    if($usuario=="administrador"){
                    ?>
                    <li><a href="administrar.php">Administrar</a></li>
                    <?PHP
                    }?>
                </ul>
                <?PHP
                }
                ?>
                
            </div>
            <div class="secc" id="ranking">
                <h2>Ranking</h2>
                
                <table id="tabla">
                    <tr id="t_cabecera" class="t_cabecera">
                        <th>Posición</th>
                        <th>Nombre</th>
                        <th>Partidos jugados</th>
                        <th>Partidos ganados</th>
                        <th>Partidos perdidos</th>
                        <th>Ratio</th>
                        <th>Puntos</th>
                    </tr>
                <?PHP
               $sentencia = "SELECT nombre, p_jugados, p_ganados, p_perdidos FROM jugador " .
        "ORDER BY p_ganados DESC";
                //hacemos la consulta
               $lista=consulta($sentencia);
               $columna = $lista->fetchAll();//guardo el resultado
               if (isset($columna)){// si existe $columna
                   
                    foreach ($columna as $indice => $valor){
                        $puntos=0;
                        $jugados=0;
                        $ganados=0;
                        echo "<tr>";
                        $posicion=$indice+1;
                        echo "<td>".$posicion."</td>";
                            for ($i=0; $i<4;$i++){
                               echo "<td>".$columna[$indice][$i]."</td>";
                               if($i==1){
                                   $jugados=$columna[$indice][$i];
                               }
                               if($i==2){
                                   $ganados=$columna[$indice][$i];
                                   $puntos=$columna[$indice][$i]*3;
                               }
                               if($i==3){
                                   $perdidos=$columna[$indice][$i];
                               }
                            }
                            if($jugados==0){
                                $ratio=0;
                            }else{
                                $ratio=($ganados-$perdidos)/$jugados;
                            }
                            echo "<td>".$ratio." %</td>";
                            echo "<td>".$puntos."</td>";
                        echo "</tr>";  
                    }
               
             }
                ?>
                </table>
            </div>
            <div class="secc" id="fotos">
                <h2>Fotos</h2>
                
                
            </div>
            <div class="secc">
                <h2>Area de Socios</h2>
                
            </div>
            
        
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
