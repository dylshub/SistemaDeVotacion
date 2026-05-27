<?php
session_start();
if($_SESSION['rol']!='admin'){
    header('Location: ../auth/login.php');
}

require '../includes/conexion.php';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main">

<div class="card">
<h1>Panel Administrador</h1>
<p>Bienvenido <?php echo $_SESSION['nombre']; ?></p>
</div>

<div class="card">
<h3>Sistema Electoral Guatemala 2028</h3>
<p>Administración general del sistema.</p>
</div>

</div>

</body>
</html>