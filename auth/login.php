<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
<title>Login</title>
</head>
<body>

<div class="login-box">
<h2>Elecciones Guatemala 2028</h2>

<form method="POST" action="validar.php">
<input type="email" name="correo" placeholder="Correo" required>
<input type="password" name="password" placeholder="Contraseña" required>
<button type="submit">Ingresar</button>
</form>

</div>

</body>
</html>