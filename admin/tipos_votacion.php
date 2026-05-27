<?php
session_start();
require '../includes/conexion.php';

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];

    mysqli_query($con,"INSERT INTO tipos_votacion(nombre)
    VALUES('$nombre')");
}

$tipos = mysqli_query($con,"SELECT * FROM tipos_votacion");
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
<h2>Tipos de Votación</h2>

<form method="POST">
<input type="text" name="nombre" placeholder="Tipo de votación">
<button name="guardar">Guardar</button>
</form>

</div>

<div class="card">
<table>
<tr>
<th>ID</th>
<th>Nombre</th>
</tr>

<?php while($t=mysqli_fetch_assoc($tipos)){ ?>
<tr>
<td><?php echo $t['id']; ?></td>
<td><?php echo $t['nombre']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>