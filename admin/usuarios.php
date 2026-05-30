<?php
session_start();
require_once("../includes/conexion.php");

/*
|--------------------------------------------------------------------------
| GUARDAR USUARIO
|--------------------------------------------------------------------------
*/

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = md5($_POST['password']);
    $rol = $_POST['rol'];
    $mesa = $_POST['mesa'];

    mysqli_query($con,"
    INSERT INTO usuarios(
        nombre,
        correo,
        password,
        rol,
        mesa_id
    )
    VALUES(
        '$nombre',
        '$correo',
        '$password',
        '$rol',
        '$mesa'
    )
    ");
}

/*
|--------------------------------------------------------------------------
| OBTENER MESAS
|--------------------------------------------------------------------------
*/

$mesas = mysqli_query($con,"
SELECT * FROM mesas
ORDER BY numero_mesa ASC
");

/*
|--------------------------------------------------------------------------
| LISTAR USUARIOS
|--------------------------------------------------------------------------
*/

$usuarios = mysqli_query($con,"
SELECT
    usuarios.*,
    mesas.numero_mesa

FROM usuarios

LEFT JOIN mesas
ON usuarios.mesa_id = mesas.id

ORDER BY usuarios.id DESC
");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Usuarios</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#f4f6f9;
}

.main{
    margin-left:260px;
    padding:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0px 4px 12px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

h2{
    margin-top:0;
    color:#0b1f3a;
}

input,
select{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

button{
    margin-top:15px;
    padding:12px 20px;
    border:none;
    border-radius:8px;
    background:#0b1f3a;
    color:white;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#13335e;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#0b1f3a;
    color:white;
    padding:14px;
}

table td{
    padding:14px;
    border-bottom:1px solid #ddd;
}

.rol-admin{
    background:#c1121f;
    color:white;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

.rol-votante{
    background:#2a9d8f;
    color:white;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main">

<!-- FORMULARIO -->

<div class="card">

<h2>Registrar Usuario</h2>

<form method="POST">

<input
type="text"
name="nombre"
placeholder="Nombre completo"
required
>

<input
type="email"
name="correo"
placeholder="Correo electrónico"
required
>

<input
type="password"
name="password"
placeholder="Contraseña"
required
>

<select name="rol" required>

<option value="">
Seleccione rol
</option>

<option value="admin">
Administrador
</option>

<option value="votante">
Votante
</option>

</select>

<select name="mesa" required>

<option value="">
Seleccione mesa
</option>

<?php while($m=mysqli_fetch_assoc($mesas)){ ?>

<option value="<?php echo $m['id']; ?>">

<?php echo $m['numero_mesa']; ?>
-
<?php echo $m['municipio']; ?>

</option>

<?php } ?>

</select>

<button name="guardar">
Guardar Usuario
</button>

</form>

</div>

<!-- TABLA -->

<div class="card">

<h2>Usuarios Registrados</h2>

<table>

<tr>

<th>ID</th>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Mesa</th>

</tr>

<?php while($u=mysqli_fetch_assoc($usuarios)){ ?>

<tr>

<td>
<?php echo $u['id']; ?>
</td>

<td>
<?php echo $u['nombre']; ?>
</td>

<td>
<?php echo $u['correo']; ?>
</td>

<td>

<?php if($u['rol']=="admin"){ ?>

<span class="rol-admin">
Administrador
</span>

<?php } else { ?>

<span class="rol-votante">
Votante
</span>

<?php } ?>

</td>

<td>

<?php
if($u['numero_mesa']){
    echo $u['numero_mesa'];
}else{
    echo "Sin asignar";
}
?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>