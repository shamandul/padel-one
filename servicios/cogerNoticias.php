<?php
 
    $xml = simplexml_load_file('http://192.168.1.224/DWES/WebPadelOne/xml/noticias.xml');
        //muestro las noticias
       
    for ($i=0;$i<count($xml);$i++){
             
        $res[] = $xml->noticia[$i];

    }
    echo \json_encode($res);