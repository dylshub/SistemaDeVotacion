<?php
session_start();
require_once("../includes/conexion.php");

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| TOTAL DE VOTOS
|--------------------------------------------------------------------------
*/

$totalVotos = mysqli_query($con,"
SELECT COUNT(*) total
FROM votos
");

$totalVotos = mysqli_fetch_assoc($totalVotos)['total'];

/*
|--------------------------------------------------------------------------
| CANDIDATOS Y ESTADÍSTICAS
|--------------------------------------------------------------------------
*/

$candidatos = mysqli_query($con,"
SELECT
    candidatos.nombre,
    candidatos.votos,

    partidos.nombre AS partido,

    tipos_votacion.nombre AS tipo

FROM candidatos

INNER JOIN partidos
ON candidatos.partido_id = partidos.id

INNER JOIN tipos_votacion
ON candidatos.tipo_id = tipos_votacion.id

ORDER BY candidatos.votos DESC
");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel del Votante</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#f4f6f9;
}

/* NAVBAR */

.navbar{
    background:#0b1f3a;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.navbar h2{
    margin:0;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:15px;
}

/* MAIN */

.main{
    padding:30px;
}

/* CARDS */

.card{
    background:white;
    border-radius:15px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0px 4px 12px rgba(0,0,0,0.08);
}

.welcome{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn{
    padding:12px 20px;
    background:#0b1f3a;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.btn:hover{
    background:#13335e;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.stat-card{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0px 4px 12px rgba(0,0,0,0.08);
    text-align:center;
}

.stat-card h1{
    margin:0;
    color:#0b1f3a;
    font-size:40px;
}

/* TABLE */

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

/* BARRAS */

.barra{
    width:100%;
    background:#ddd;
    border-radius:10px;
    overflow:hidden;
}

.progreso{
    height:18px;
    background:#0b1f3a;
}

</style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

<h2>Votaciones Guatemala 2028</h2>

<div>

<a href="dashboard.php">Inicio</a>

<a href="votar.php">Votar</a>

<a href="../auth/logout.php">Cerrar Sesión</a>

</div>

</div>

<!-- MAIN -->

<div class="main">

<!-- BIENVENIDA -->

<div class="card welcome">

<div>

<h1>
Bienvenido,
<?php echo $_SESSION['nombre']; ?>
</h1>

<p>
A continuación puedes ver las estadísticas actuales de las votaciones, así como el total de votos registrados hasta el momento.
</p>

</div>

<div>

<a href="votar.php" class="btn">
Ir a votar
</a>

</div>

</div>

<!-- ESTADÍSTICAS -->

<div class="stats">

<div class="stat-card">

<h3>Total de votos</h3>

<h1>
<?php echo $totalVotos; ?>
</h1>

</div>

</div>

<!-- CANDIDATOS -->

<div class="card">

<h2>Estadísticas Electorales</h2>

<table>

<tr>

<th>Candidato</th>
<th>Partido</th>
<th>Categoría</th>
<th>Votos</th>
<th>Porcentaje</th>

</tr>

<?php while($c=mysqli_fetch_assoc($candidatos)){

$porcentaje = 0;

if($totalVotos > 0){
    $porcentaje = ($c['votos'] * 100) / $totalVotos;
}

?>

<tr>

<td>
<?php echo $c['nombre']; ?>
</td>

<td>
<?php echo $c['partido']; ?>
</td>

<td>
<?php echo $c['tipo']; ?>
</td>

<td>
<?php echo $c['votos']; ?>
</td>

<td width="300">

<div class="barra">

<div
class="progreso"
style="width: <?php echo $porcentaje; ?>%">
</div>

</div>

<br>

<?php echo round($porcentaje,2); ?>%

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>