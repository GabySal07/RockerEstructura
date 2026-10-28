<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibe_Shop</title>
    <link rel="website icon" href="imagenes/logo.jpg">
</head>
<body>
    <br>
    <br>
    <br>
        <div class="conter">
            <h1>Bienvenido a</h1>
            <div id="div"><img src="imagenes" width="370px"><br></div>
            <br>
        <form action="validar.php" method="post" onsubmit="return validar()">
            <table>
                <tr>
                    <td><label for="correo">Correo:</label></td>
                    <td><input type="Email" id="correo" name="correo" placeholder="Ingrese su correo" required></td>
                </tr>
                <tr>
                    <td><label for="pass">Contraseña:</label></td>
                    <td><input type="password" id="pass" name="pass" placeholder="Ingrese su contraseña" required></td>
                </tr>
            </table>
            <br>
            <br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if(isset($_SESSION['NoUsu'])){?>
        <p id="Error" style="color:red"><?php echo $_SESSION['NoUsu']?></p>
        <?php } ?>
    <br>
    <p>Si aún no tiene una cuenta <a href="registro.php">Registrate</a></p>
        </div>
        <script>
        function validar(){
            let correo=document.getElementById('correo').value;
            let pass=document.getElementById('pass').value;
            if(correo=="" || pass==""){
                alert("Llena todos los datos");
                return false;
            }
            if(!validaremail(correo)){
                alert("El correo debe tener mayusculas y minusculas/verificar el correo.");
                return false;
            }
            if(!validarpass(pass)){
                alert("La contraseña debe tener mayusculas, minusculas, al menos un numero, alguno de los siguientes caracteres especiales: -_/*#$ y de 6 a 12 caracteres.");
                return false;
            }
        }
        function validaremail(correo){
            const va=/^[a-zA-Z]+@[A-Za-z]+\.([a-zA-Z]{2,4})+\.([a-zA-Z]{2,4})$/.test(correo);
            const va2=/^[a-zA-Z]+@[A-Za-z]+\.([a-zA-Z]{2,4})$/.test(correo);
            return va || va2;
        }
        function validarusuario(usuario){
            const va=/[a-z]/.test(usuario);
            const va2=/[A-Z]/.test(usuario);
            const va3=/[\d]/.test(usuario);
            const va4=/[$@!%*?&]/.test(usuario);
            const va5=usuario.length<=9;
            return va && va2 && va3 && va4 && va5;
        }
        function validarpass(pass){
            const va=/^(?=.*[a-z])(?=.*[A-Z])(?=.*[-_/*#$])(?=.*[0-9])[a-zA-Z-_/*#$0-9]{6,12}$/;
            return va.test(pass);
        }
        </script>
</body>
</html>
