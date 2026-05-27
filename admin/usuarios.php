<?php
session_start();
require '../includes/conexion.php';

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = md5($_POST['password']);
    $rol = $_POST['rol'];

    mysqli_query($con,"INSERT INTO usuarios(nombre,correo,password,rol)
    VALUES('$nombre','$correo','$password','$rol')");
}

$usuarios = mysqli_query($con,"SELECT * FROM usuarios");
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
<h2>Usuarios</h2>

<form method="POST">
<input type="text" name="nombre" placeholder="Nombre" required>
<input type="email" name="correo" placeholder="Correo" required>
<input type="password" name="password" placeholder="Contraseña" required>

<select name="rol">
<option value="votante">Votante</option>
<option value="admin">Administrador</option>
</select>

<button name="guardar">Guardar</button>
</form>

</div>

<div class="card">
<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
</tr>

<?php while($u=mysqli_fetch_assoc($usuarios)){ ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo $u['nombre']; ?></td>
<td><?php echo $u['correo']; ?></td>
<td><?php echo $u['rol']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>