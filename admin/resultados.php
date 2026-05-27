<?php
session_start();
require '../includes/conexion.php';

$resultados = mysqli_query($con,"SELECT c.nombre,p.nombre AS partido,t.nombre AS tipo,c.votos
FROM candidatos c
INNER JOIN partidos p ON c.partido_id=p.id
INNER JOIN tipos_votacion t ON c.tipo_id=t.id
ORDER BY c.votos DESC");
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
<h2>Resultados</h2>

<table>
<tr>
<th>Candidato</th>
<th>Partido</th>
<th>Tipo</th>
<th>Votos</th>
</tr>

<?php while($r=mysqli_fetch_assoc($resultados)){ ?>
<tr>
<td><?php echo $r['nombre']; ?></td>
<td><?php echo $r['partido']; ?></td>
<td><?php echo $r['tipo']; ?></td>
<td><?php echo $r['votos']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>