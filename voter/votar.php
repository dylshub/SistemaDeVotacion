<?php
session_start();
require '../includes/conexion.php';

$tipos = mysqli_query($con,"SELECT * FROM tipos_votacion");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="main">

<div class="card">
<h2>Emitir voto</h2>

<?php while($t=mysqli_fetch_assoc($tipos)){ ?>

<h3><?php echo $t['nombre']; ?></h3>

<?php
$candidatos = mysqli_query($con,"SELECT c.*, p.nombre AS partido
FROM candidatos c
INNER JOIN partidos p ON c.partido_id=p.id
WHERE tipo_id='{$t['id']}'");

while($c=mysqli_fetch_assoc($candidatos)){
?>

<div class="card">
<h4><?php echo $c['nombre']; ?></h4>
<p><?php echo $c['partido']; ?></p>

<form method="POST" action="confirmar.php">
<input type="hidden" name="candidato" value="<?php echo $c['id']; ?>">
<input type="hidden" name="tipo" value="<?php echo $t['id']; ?>">
<button>Votar</button>
</form>

</div>

<?php } ?>

<?php } ?>

</div>

</body>
</html>