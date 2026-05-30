<?php
session_start();
require '../includes/conexion.php';

/*
|--------------------------------------------------------------------------
| VALIDAR SESIÓN
|--------------------------------------------------------------------------
*/

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| RECIBIR DATOS
|--------------------------------------------------------------------------
*/

$usuario = $_SESSION['id'];
$candidato = $_POST['candidato'];
$tipo = $_POST['tipo'];

/*
|--------------------------------------------------------------------------
| VALIDAR DOBLE VOTO
|--------------------------------------------------------------------------
*/

$validar = mysqli_query($con,"
SELECT *
FROM votos
WHERE usuario_id='$usuario'
AND tipo_id='$tipo'
");

/*
|--------------------------------------------------------------------------
| SI YA VOTÓ
|--------------------------------------------------------------------------
*/

if(mysqli_num_rows($validar)>0){
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ya votaste</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:100%;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:420px;
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0px 4px 15px rgba(0,0,0,0.1);
    text-align:center;
}

.icon{
    font-size:80px;
    color:#e74c3c;
}

h1{
    color:#0b1f3a;
}

p{
    color:#555;
    margin-top:10px;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#0b1f3a;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.btn:hover{
    background:#13335e;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="icon">⚠️</div>

<h1>Ya realizaste tu voto</h1>

<p>
Ya votaste en esta categoría electoral.
No puedes volver a votar aquí.
</p>

<a href="dashboard.php" class="btn">
Regresar
</a>

</div>

</div>

</body>
</html>

<?php
exit();
}

/*
|--------------------------------------------------------------------------
| GUARDAR VOTO
|--------------------------------------------------------------------------
*/
$mesaUsuario = mysqli_query($con,"
SELECT mesa_id
FROM usuarios
WHERE id='$usuario'
");

$mesaUsuario = mysqli_fetch_assoc($mesaUsuario);

$mesa_id = $mesaUsuario['mesa_id'];

mysqli_query($con,"
INSERT INTO votos
(usuario_id,candidato_id,tipo_id,mesa_id)

VALUES
('$usuario','$candidato','$tipo','$mesa_id')
");
/*
|--------------------------------------------------------------------------
| SUMAR VOTO AL CANDIDATO
|--------------------------------------------------------------------------
*/

mysqli_query($con,"
UPDATE candidatos
SET votos = votos + 1
WHERE id='$candidato'
");

/*
|--------------------------------------------------------------------------
| VERIFICAR CUÁNTOS TIPOS FALTAN
|--------------------------------------------------------------------------
*/

$totalTipos = mysqli_query($con,"
SELECT COUNT(*) total
FROM tipos_votacion
");

$totalTipos = mysqli_fetch_assoc($totalTipos)['total'];

$votados = mysqli_query($con,"
SELECT COUNT(*) total
FROM votos
WHERE usuario_id='$usuario'
");

$votados = mysqli_fetch_assoc($votados)['total'];

$pendientes = $totalTipos - $votados;

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Voto Registrado</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:100%;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:450px;
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0px 4px 15px rgba(0,0,0,0.1);
    text-align:center;
}

.icon{
    font-size:80px;
    color:#2ecc71;
}

h1{
    color:#0b1f3a;
}

p{
    color:#555;
    margin-top:10px;
    line-height:1.6;
}

.botones{
    margin-top:25px;
}

.btn{
    display:inline-block;
    padding:12px 25px;
    margin:5px;
    background:#0b1f3a;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.btn:hover{
    background:#13335e;
}

.btn-secundario{
    background:#27ae60;
}

.btn-secundario:hover{
    background:#1e8449;
}

.estado{
    margin-top:20px;
    background:#f1f1f1;
    padding:15px;
    border-radius:10px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="icon">✔️</div>

<h1>¡Voto registrado!</h1>

<p>
Tu voto fue registrado correctamente en el sistema electoral.
</p>

<div class="estado">

<p>

<strong>Tipos pendientes por votar:</strong>

<?php echo $pendientes; ?>

</p>

</div>

<div class="botones">

<a href="votar.php" class="btn btn-secundario">
Continuar Votando
</a>

<a href="dashboard.php" class="btn">
Ir al Panel
</a>

</div>

</div>

</div>

</body>
</html>