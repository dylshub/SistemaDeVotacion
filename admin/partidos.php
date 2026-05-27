<?php
session_start();
require '../includes/conexion.php';

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $siglas = $_POST['siglas'];

    mysqli_query($con,"INSERT INTO partidos(nombre,siglas)
    VALUES('$nombre','$siglas')");
}

$partidos = mysqli_query($con,"SELECT * FROM partidos");
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
<h2>Partidos</h2>

<form method="POST">
<input type="text" name="nombre" placeholder="Nombre partido">
<input type="text" name="siglas" placeholder="Siglas">
<button name="guardar">Guardar</button>
</form>

</div>

<div class="card">
<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Siglas</th>
</tr>

<?php while($p=mysqli_fetch_assoc($partidos)){ ?>
<tr>
<td><?php echo $p['id']; ?></td>
<td><?php echo $p['nombre']; ?></td>
<td><?php echo $p['siglas']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>