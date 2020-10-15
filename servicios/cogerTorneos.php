<?php
/*
 * Creado por Jesús de Serdio
 * 
 * Servicio cogerTorneos
 */

    try {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=padelonedb";
        $pdoConex = new PDO($dsn, "administrador", "administrador", $opc);
    }
    catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    // Ejecutamos la consulta 
    $sql = "SELECT p.cod_torneo, j.nombre FROM participa p, jugador j WHERE p.cod_jugador=j.cod_jugador ORDER BY p.cod_torneo";
    //ORDER BY p.cod_torneo
    $datos=array();
    $rs=$pdoConex->query($sql);
    //cargamos los datos en el array
    $datos = $rs->fetchAll(PDO::FETCH_ASSOC);
   // Mostramos el array en formato JSON
    echo json_encode($datos);
