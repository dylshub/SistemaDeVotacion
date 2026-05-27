<?php
session_start();
require '../includes/conexion.php';

$logs = mysqli_query($con,"SELECT * FROM auditoria ORDER BY fecha DESC");
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
<h2>Auditoría</h2>

<table>
<tr>
<th>Usuario</th>
<th>Acción</th>
<th>Fecha</th>
</tr>

<?php while($l=mysqli_fetch_assoc($logs)){ ?>
<tr>
<td><?php echo $l['usuario']; ?></td>
<td><?php echo $l['accion']; ?></td>
<td><?php echo $l['fecha']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>