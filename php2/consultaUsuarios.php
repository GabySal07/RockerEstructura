<?php
session_start();
$_SESSION['usu']="";
include_once("conn.php");
class usuarios{
    public function buscaCuenta($correo){/* regresar arreglo con los registros encontrados */
        $c= new conn();
        $pdo=$c->coneccion();/* obtene conexion de archivo conn.php */
        $query= "select usuarios.correo, usuarios.pass, cliente.id_cliente, cliente.nombre, cliente.ap, cliente.am from usuarios INNER JOIN cliente ON cliente.id_correo=usuarios.correo where cliente.id_correo='$correo'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    public function cuentaDomi($correo){/* regresar arreglo con los registros encontrados */
        $c= new conn();
        $pdo=$c->coneccion();/* obtene conexion de archivo conn.php */
        $query= "select cuenta.no_cuenta, cuenta.usu_cuenta, cuenta.estado, cuenta.col, cuenta.mun, cuenta.calle, cuenta.no_int, cuenta.no_ext from usuarios inner join cliente on cliente.id_correo=usuarios.correo inner join cuenta on cuenta.id_cliente=cliente.id_cliente where usuarios.correo='$correo'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['cuentadomi']=$res;
        return $res;
    }
    public function buscarUsuario($correo,$pass){/* regresar arreglo con los registros encontrados */
        $c= new conn();
        $pdo=$c->coneccion();/* obtene conexion de archivo conn.php */
        $query= "select usuarios.correo, usuarios.pass, cliente.tel, cliente.id_cliente, cliente.nombre, cliente.ap, cliente.am from usuarios INNER JOIN cliente ON cliente.id_correo=usuarios.correo where cliente.id_correo='$correo' AND usuarios.pass='$pass'";/* cadena de consulta */
        $stmt=$pdo->prepare($query); /* prepara consulta */
        $stmt->execute();/* envia usuario y password a la ejecucion */
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);/* crear arreglo solo en los casos de select */
        if(count($res)<=0){
            $c1= new conn();
            $pdo1=$c1->coneccion();/* obtene conexion de archivo conn.php */
            $query1= "select usuarios.correo, usuarios.pass, empleados.no_empleados from usuarios INNER JOIN empleados ON empleados.id_correo=usuarios.correo where empleados.id_correo='$correo' AND usuarios.pass='$pass'";
            $stmt1=$pdo1->prepare($query1); /* prepara consulta */
            $stmt1->execute();/* envia usuario y password a la ejecucion */
            $res1=$stmt1->fetchAll(PDO::FETCH_ASSOC);/* crear arreglo solo en los casos de select */
            if(count($res1)<=0){
                $_SESSION['usu']="";
                $valor=3;
                return $valor;
            }else{
                $_SESSION['usu']=$res1;
                $valor=2;
                return $valor;
            }
        }else{
            $_SESSION['usu']=$res;
            $valor=1;
            return $valor;
        }
        return $res;
    }
    public function crearUsuario($correo,$pass,$nombre,$ap,$am,$tel){
        $c= new conn();
        $pdo=$c->coneccion();/* obtene conexion de archivo conn.php */
        $query= "select * from usuarios where correo='$correo'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($res)<=0){
            $c= new conn();
            $pdo=$c->coneccion();
            $query= "insert into usuarios(correo,pass) values(?,?)";
            $stmt=$pdo->prepare($query);
            $stmt->execute([$correo,$pass]);
            $res=$stmt->rowCount();
            if($res>0){
                $c1= new conn();
                $pdo1=$c1->coneccion();
                $query1= "insert into cliente(nombre,ap,am,tel,id_correo) values(?,?,?,?,?)";
                $stmt1=$pdo1->prepare($query1);
                $stmt1->execute([$nombre,$ap,$am,$tel,$correo]);
                $res=$stmt1->rowCount();
                $valor=2;
                return $valor;
            }else{
                echo "ERROR EN USUARIOS";
            }
        }else{
            $valor=1;
            return $valor;
        }
    }
    public function actualizarUsuario($newpass,$newtel,$correo){
        $c= new conn();
        $pdo=$c->coneccion();
        if($newpass != null){
            $sql = "UPDATE usuarios SET pass='$newpass' WHERE correo='$correo'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newtel != null){
            $sql = "UPDATE cliente SET tel='$newtel' WHERE id_correo='$correo'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        $query= "select usuarios.correo, usuarios.pass, cliente.tel, cliente.id_cliente, cliente.nombre, cliente.ap, cliente.am from usuarios INNER JOIN cliente ON cliente.id_correo=usuarios.correo where cliente.id_correo='$correo'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    public function actualizarCuenta($newcuenta,$newusu,$newcol,$newmun,$newcalle,$newint,$newext,$nocuenta){
        $c= new conn();
        $pdo=$c->coneccion();
        if($newusu != null){
            $sql = "UPDATE cuenta SET usu_cuenta='$newusu' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newcol != null){
            $sql = "UPDATE cuenta SET col='$newcol' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newmun != null){
            $sql = "UPDATE cuenta SET mun='$newmun' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newcalle != null){
            $sql = "UPDATE cuenta SET calle='$newcalle' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newint != null){
            $sql = "UPDATE cuenta SET no_int='$newint' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newext != null){
            $sql = "UPDATE cuenta SET no_ext='$newext' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        if($newcuenta != null){
            $sql = "UPDATE cuenta SET no_cuenta='$newcuenta' WHERE no_cuenta='$nocuenta'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }else{}
        $query= "select cuenta.no_cuenta, cuenta.usu_cuenta, cuenta.estado, cuenta.col, cuenta.mun, cuenta.calle, cuenta.no_int, cuenta.no_ext from cuenta where no_cuenta='$nocuenta'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}
?>
