<?php

    try {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=padelonedb";
        $pdoConex = new PDO($dsn, "administrador", "administrador", $opc);
    }
    catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    // Ejecutamos la consulta 
    $sql = "SELECT nombre, p_jugados, p_ganados, p_perdidos FROM jugador " .
            "ORDER BY p_ganados DESC";
    $datos=array();
    $rs=$pdoConex->query($sql);
    //cargamos los datos en el array
    $datos = $rs->fetchAll(PDO::FETCH_ASSOC);
   // Mostramos el array en formato JSON
    echo json_encode($datos);
