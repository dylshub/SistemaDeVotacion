<?php
session_start();
require_once("../includes/conexion.php");

/*
|--------------------------------------------------------------------------
| GUARDAR MESA
|--------------------------------------------------------------------------
*/

if(isset($_POST['guardar'])){

    $numero = $_POST['numero'];
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];
    $direccion = $_POST['direccion'];

    mysqli_query($con,"
    INSERT INTO mesas(
        numero_mesa,
        departamento,
        municipio,
        direccion,
        estado
    )
    VALUES(
        '$numero',
        '$departamento',
        '$municipio',
        '$direccion',
        'Activa'
    )
    ");
}

/*
|--------------------------------------------------------------------------
| LISTAR MESAS
|--------------------------------------------------------------------------
*/

$mesas = mysqli_query($con,"
SELECT * FROM mesas
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mesas Electorales</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    margin:0;
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
    box-shadow:0px 4px 10px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

button{
    margin-top:15px;
    padding:12px 20px;
    background:#0b1f3a;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
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

.estado{
    background:green;
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

<div class="card">

<h2>Registrar Mesa Electoral</h2>

<form method="POST">

<input
type="text"
name="numero"
placeholder="Número de mesa"
required
>

<input
type="text"
name="departamento"
placeholder="Departamento"
required
>

<input
type="text"
name="municipio"
placeholder="Municipio"
required
>

<input
type="text"
name="direccion"
placeholder="Dirección o centro de votación"
required
>

<button name="guardar">
Guardar Mesa
</button>

</form>

</div>

<div class="card">

<h2>Listado de Mesas</h2>

<table>

<tr>
<th>Mesa</th>
<th>Departamento</th>
<th>Municipio</th>
<th>Dirección</th>
<th>Estado</th>
</tr>

<?php while($m=mysqli_fetch_assoc($mesas)){ ?>

<tr>

<td>
<?php echo $m['numero_mesa']; ?>
</td>

<td>
<?php echo $m['departamento']; ?>
</td>

<td>
<?php echo $m['municipio']; ?>
</td>

<td>
<?php echo $m['direccion']; ?>
</td>

<td>
<span class="estado">
<?php echo $m['estado']; ?>
</span>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html