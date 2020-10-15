<!DOCTYPE html>
<?php
    $error="";
    // Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['enviar'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
       
        if (empty($usuario) || empty($password)) {
            $error = "Debes introducir un nombre de usuario y una contraseña";
        }
        else {
            // Comprobamos las credenciales con la base de datos
            // Conectamos a la base de datos
            if($usuario=="administrador"){
                $usuariodb="administrador";
                $passdb="administrador";
            }  else {
                $usuariodb="jugador";
                $passdb="jugador";
            }
            try {
                $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
                $dsn = "mysql:host=localhost;dbname=padelonedb";
                $pdoConex = new PDO($dsn, $usuariodb, $passdb, $opc);
            }
            catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

             // Ejecutamos la consulta para comprobar las credenciales
            // 
            $sql = "SELECT nombre FROM usuario " .
            "WHERE nombre='$usuario' " .
            "AND password='" .$password. "'";
            
            if($resultado = $pdoConex->query($sql)) {
                $fila = $resultado->fetch();
                if ($fila != null) {
                    session_start();
                    $_SESSION['usuario']=$usuario;
                    header("Location: index.php");                    
                }
                else {
                    // Si las credenciales no son válidas, se vuelven a pedir
                    
                    $error = "Usuario o contraseña no válidos!";
                }
                unset($resultado);
            }
            unset($pdoConex);   

        }
   }
   ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilopadel.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Dr+Sugiyama' rel='stylesheet' type='text/css'>
        <title>Página Web Padel las Salinas</title>
        <?PHP
        $error="";
        ?>
    </head>
    <body>
        <nav>
            <h1>Padel las Salinas</h1>
            <ul>
               <li><a href="index.php">Inicio</a></li>
               <li><a href="principal.php" >Noticias</a></li>
               <li><a href="insercion.php">Participa</a></li>
               <li><a href="modificacion.php">Ranking</a></li>
               <li><a class="pag_actual" href="#">Login</a></li>
            </ul>
        </nav>
        
         <div id='login'>
            <form action='login.php' method='post'>
                <fieldset >
                    <legend>Login</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='usuario' >Usuario:</label><br/>
                        <input type='text' name='usuario' id='usuario' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <label for='password' >Contraseña:</label><br/>
                        <input type='password' name='password' id='password' maxlength="50" /><br/>
                    </div>

                    <div class='campo'>
                        <input type='submit' name='enviar' value='Enviar' />
                    </div>
                </fieldset>
            </form>
         </div>
        
            
    </body>
</html>
