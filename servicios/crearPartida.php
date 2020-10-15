<?php
/*
 * Creado por Jesús de Serdio
 * 
 * CrearPartida
 */


$jugador1 = $_REQUEST['jugador1'];
$jugador2 = $_REQUEST['jugador2'];
$jugador3 = $_REQUEST['jugador3'];
$jugador4 = $_REQUEST['jugador4'];

require_once '../funciones/funcionesDB.inc';
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
    //añadimos 1 partido jugado
    


// Función que nos perite insertar a los jugadores
function insertarJugador($jugador,$cod_torneo, $fecha){
    $consulta=consulta("SELECT cod_jugador from jugador WHERE nombre='".$jugador."'");
    $consulta->setFetchMode(PDO::FETCH_NUM);
    $cod_jugador =  $consulta->fetch();

    $sentencia="INSERT  INTO participa  (cod_jugador, cod_torneo,fecha) VALUE (:cod_jugador, :cod_torneo, :fecha)";
    insertarPreparada($sentencia,array($cod_jugador[0], $cod_torneo[0], $fecha));
    sumarPartidoJugado($cod_jugador[0]);
}
//Sumamos un partido al que ya tenga
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