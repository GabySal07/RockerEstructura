<?php
class conn{
    public function coneccion(){
        $h="localhost";
        $u="";
        $p="";
        $db="";
        try{
            $conn= new PDO("mysql:host=".h.";dbname=".db,u,p);
            $conn->setAttribute(PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_SILENT);
            return $conn;
        }catch(PDOException $e){
            echo "Connection failed".$e->getMessage();
            return 0;
        }
    }
}
?>
