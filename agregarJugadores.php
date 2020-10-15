
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
            $usuario=$_POST['usuario'];
            $pass=$_POST['password'];
            $nombre=$_POST['nombre'];
            $dni=$_POST['dni'];
            $direc=$_POST['direccion'];
            $tlf=$_POST['tlf'];
            $email=$_POST['email'];
            // agregamos usuario
            $sentencia='INSERT INTO usuario(nombre, password) VALUE("'.$usuario.'","'.$pass.'")';
            insertar($sentencia);
            // agregamos jugador
             $sentencia2='INSERT INTO jugador (dni, nombre, telefono, direccion, correo,'
                     . 'p_ganados, p_perdidos, p_jugados)'
                     . ' VALUE("'.$dni.'","'.$nombre.'","'.$tlf.'","'.$direc.'","'
                     .$email.'",0,0,0)';
            insertar($sentencia2);   
            
        }
        ?>
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
        <div class="secc" id="admin">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
                <fieldset >
                    <legend>Agregar Nuevo Usuario</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='usuario' >Usuario:</label>
                        <input type='text' name='usuario'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='password' >Contraseña:</label>
                        <input type='password' name='password'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='nombre' >Nombre: </label>
                        <input type='text' name='nombre'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='dni' >DNI:</label>
                        <input type='text' name='dni'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='direccion' >Direccón: </label>
                        <input type='text' name='direccion'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='tlf' >Teléfono:</label>
                        <input type='text' name='tlf'  maxlength="50" />
                    </div>
                    <div class='campo'>
                        <label for='email' >E-mail: </label>
                        <input type='text' name='email'  maxlength="50" />
                    </div>
                    
                    <div class='campo'>
                        <input type='submit' name='enviar' value='Enviar' />
                    </div>
                </fieldset>
            </form>
         </div>
        
            
    </body>
</html>
