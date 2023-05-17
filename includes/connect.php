<?php
function connect(){
    require_once('config.php');
    try{
        $options=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
        $connect= new PDO ($dsn,$user,$pass,$options);
        return $connect;
    } catch (PDOexception $e){
        echo $e->getMessage();
        die("Fin du programme...<br>");
    }
}
?>