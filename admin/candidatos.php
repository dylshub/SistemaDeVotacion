<?php
session_start();
require_once("../includes/conexion.php");
?>

<?php
$partidos = mysqli_query($con,"SELECT * FROM partidos");
$tipos = mysqli_query($con,"SELECT * FROM tipos_votacion");
$candidatos = mysqli_query($con,"
SELECT 
    candidatos.id,
    candidatos.nombre,
    candidatos.votos,
    partidos.nombre AS partido,
    tipos_votacion.nombre AS tipo

FROM candidatos

INNER JOIN partidos
ON candidatos.partido_id = partidos.id

INNER JOIN tipos_votacion
ON candidatos.tipo_id = tipos_votacion.id
");
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
<h2>Candidatos</h2>

<form method="POST">
<input type="text" name="nombre" placeholder="Nombre candidato">

<select name="partido">
<?php while($p=mysqli_fetch_assoc($partidos)){ ?>
<option value="<?php echo $p['id']; ?>">
<?php echo $p['nombre']; ?>
</option>
<?php } ?>
</select>

<select name="tipo">
<?php while($t=mysqli_fetch_assoc($tipos)){ ?>
<option value="<?php echo $t['id']; ?>">
<?php echo $t['nombre']; ?>
</option>
<?php } ?>
</select>

<button name="guardar">Guardar</button>
</form>

</div>

<div class="card">
<table>
<tr>
<th>Nombre</th>
<th>Partido</th>
<th>Tipo</th>
<th>Votos</th>
</tr>

<?php while($c=mysqli_fetch_assoc($candidatos)){ ?>
<tr>
<td><?php echo $c['nombre']; ?></td>
<td><?php echo $c['partido']; ?></td>
<td><?php echo $c['tipo']; ?></td>
<td><?php echo $c['votos']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>