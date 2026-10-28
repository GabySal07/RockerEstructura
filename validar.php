<?php
session_start();
$_SESSION['usu']="";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    include_once("php2/consultaUsuarios.php");
    $c=new usuarios();
    $usu=$c->buscarUsuario($correo,$pass);
    if ($usu==1) {
        header("Location:Principal.php");
    } else {
        if ($usu==2) {
            header("Location:menuAdmin.php");
        } else {
            $_SESSION['NoUsu']="Usuario no encontrado";
            header("Location:index.php");
        }  
    }  
}
?>
