<?php
session_start();
require '../includes/conexion.php';

if(isset($_POST['guardar'])){

    $numero = $_POST['numero'];
    $ubicacion = $_POST['ubicacion'];

    mysqli_query($con,"INSERT INTO mesas(numero_mesa,ubicacion)
    VALUES('$numero','$ubicacion')");
}

$mesas = mysqli_query($con,"SELECT * FROM mesas");
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
<h2>Mesas</h2>

<form method="POST">
<input type="text" name="numero" placeholder="Número mesa">
<input type="text" name="ubicacion" placeholder="Ubicación">
<button name="guardar">Guardar</button>
</form>

</div>

<div class="card">
<table>
<tr>
<th>Número</th>
<th>Ubicación</th>
</tr>

<?php while($m=mysqli_fetch_assoc($mesas)){ ?>
<tr>
<td><?php echo $m['numero_mesa']; ?></td>
<td><?php echo $m['ubicacion']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>