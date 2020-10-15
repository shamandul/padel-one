<?php 
//    Conexión con la base de datos
function conexion(){
   try{
       //realizamos la conexión
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=padelonedb";
        $pdoConex = new PDO($dsn, "administrador", "administrador", $opc);
       return $pdoConex; 
       
   } catch (Exception $ex) {
       echo'<span>error en la conexi&oacute;n: '+$ex."</span>";// mensaje de errode la conexión
   }   
}

//  Consultas a la base de datos
function consulta($sentencia){
    // Establecemos conexión
    try{
        // Nos conectamos a la base de datos
        $conexion=conexion();
        // realizamos la consulta
        $resultado =$conexion->query($sentencia);
        return $resultado;
    } catch (Exception $ex) {
        echo'<span>error en la consulta: '+$ex."</span>"; // mensaje de error de la consulta
    } 
    
}
//  Insercción
function insertar($sentencia){
    // Establecemos la conexión
    try {
        $conexion=  conexion();
        //realizamos la insercción
        $conexion ->query($sentencia);
    } catch (Exception $ex) {
         echo'<span>error en la insercion: '+$ex."</span>"; 
    }
    
}
//  Insercción
function actualizar($sentencia){
    // Establecemos la conexión
    try {
        $conexion=  conexion();
        //realizamos la insercción
        $conexion ->query($sentencia);
    } catch (Exception $ex) {
         echo'<span>error en la actualización '+$ex."</span>"; 
    }
    
}
//  Modificación

//  Eliminación
function eliminar($sentencia){
    // Establecemos la conexión
    try {
        $conexion=  conexion();
        //realizamos el borrado
        $conexion ->query($sentencia);
    } catch (Exception $ex) {
         echo'<span>error en el borrado: '+$ex."</span>"; 
    }
    
}
function insertarPreparada($sentencia,$valores){
    try {
       $conexion=  conexion();
       $q= $conexion->prepare($sentencia);
       $q->bindParam(':cod_jugador', $cod_jugador);
       $q->bindParam(':cod_torneo', $cod_torneo);
       $q->bindParam(':fecha',  $fecha);
       $cod_jugador=(int)$valores[0];
       $cod_torneo=(int)$valores[1];
       $fecha=date("Y-m-d");
       $q->execute();
    } catch (Exception $ex) {
         echo'<span>error en el borrado: '+$ex."</span>"; 
    }
    
}
?>
