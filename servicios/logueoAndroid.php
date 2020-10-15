<?php
/*
 * Creado pro Jesús de Serdio
 * 
 * LogueoAndorid
 */


$usuario = $_REQUEST['usuario'];
$passw = $_REQUEST['password'];

require_once '../funciones/funcionesDB.inc';
// miramos si el usuario y contraseña esta en la base de datos
$sentencia="SELECT COUNT(*) FROM usuario WHERE nombre='$usuario' AND password='$passw'" ;
$res= consulta($sentencia);
$res->setFetchMode(PDO::FETCH_NUM);
$numero=$res->fetch();
//comparamos el resultado para ver si está o no y le asignamos un valor de estado
// si estado es cero es que no está logueado
// si el estado es uno es que el usuario y contraseña existe en la base de datos.
if($numero[0]==0){
    $resultado[]=array("estado"=>"0");
}else{
    $resultado[]=array("estado"=>"1");
}
// enviamos la respuesta en formato JSON
echo json_encode($resultado);

?>