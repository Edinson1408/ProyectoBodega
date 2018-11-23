<!DOCTYPE html>
<html lang="es">
<head>
	<title>Luiggi's Marker</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" type="image/png" href="img/logo.ico" />
	<link rel="stylesheet" href="css/materialize.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style type="text/css">
    #error{
        color: red;
    }
</style>
</head>
<div class="container">
<body class="font-cover" id="login" style="background-image: url(img/fondo_1.jpg); ">
    <div class="container-login center-align">
    <!--img src="img/1.jpg" width="100%" height="100%" margin="0"-->
        <div style="margin:15px 0;">
            <img class="responsive-img" src="img/logo_1.png" width="200" height="200">
            <p>Inicia sesión </p>   
        </div>
        <form action="control.php" method="POST">
            <div class="input-field">
                <input id="UserName" type="text" name='user'class="validate">
                <label for="UserName"><i class="zmdi zmdi-account"></i>&nbsp; Nombre</label>
            </div>
            <div class="input-field">
                <input id="Password" name='cont' type="password" class="validate">
                <label for="Password"><i class="zmdi zmdi-lock"></i>&nbsp; Contraseña</label>
            </div>
            <button name="enviar" class="waves-effect waves-teal btn-flat">Ingresar &nbsp; <i class="zmdi zmdi-mail-send"></i></button>
        </form>
        <?php
            if (isset($_GET['v1'])) {
             ?>
             <p id="error">Contraseña o usuario invalido</p>
             <?php
            }
             ?>
        <div class="divider" style="margin: 20px 0;"></div>
        <a href="http://www.EnSuRed.com">© 2018 EnSURed</a>
	</div> 
    </div>
	<script src='js/sweetalert.min.js'></script>
	<script src='js/jquery-3.2.1.min.js'></script>
	<script src="js/materialize.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>