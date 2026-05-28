<?php
session_start();
require_once("../includes/conexion.php");

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| TOTAL GENERAL
|--------------------------------------------------------------------------
*/

$totalGeneral = mysqli_query($con,"
SELECT COUNT(*) total
FROM votos
");

$totalGeneral = mysqli_fetch_assoc($totalGeneral)['total'];

/*
|--------------------------------------------------------------------------
| VOTOS POR CATEGORÍA
|--------------------------------------------------------------------------
*/

$totalesCategoria = [];

$consultaTotales = mysqli_query($con,"
SELECT 
    tipos_votacion.id,
    tipos_votacion.nombre,
    COUNT(votos.id) AS total

FROM tipos_votacion

LEFT JOIN votos
ON tipos_votacion.id = votos.tipo_id

GROUP BY tipos_votacion.id
");

while($t = mysqli_fetch_assoc($consultaTotales)){
    $totalesCategoria[$t['id']] = $t['total'];
}

/*
|--------------------------------------------------------------------------
| CANDIDATOS
|--------------------------------------------------------------------------
*/

$candidatos = mysqli_query($con,"
SELECT
    candidatos.id,
    candidatos.nombre,
    candidatos.votos,

    partidos.nombre AS partido,

    tipos_votacion.id AS tipo_id,
    tipos_votacion.nombre AS tipo

FROM candidatos

INNER JOIN partidos
ON candidatos.partido_id = partidos.id

INNER JOIN tipos_votacion
ON candidatos.tipo_id = tipos_votacion.id

ORDER BY tipos_votacion.nombre ASC, candidatos.votos DESC
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
    background:#f1f5f9;
}

/* NAVBAR */

.navbar{
    background:linear-gradient(90deg,#001f54,#003566);
    color:white;
    padding:18px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar h2{
    margin:0;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:15px;
    font-weight:bold;
}

/* MAIN */

.main{
    padding:30px;
}

/* CARDS */

.card{
    background:white;
    border-radius:18px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.welcome{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn{
    background:#003566;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#001d3d;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.stat{
    background:white;
    border-radius:18px;
    padding:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.stat h1{
    margin:0;
    font-size:40px;
    color:#003566;
}

/* TABLA */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#003566;
    color:white;
    padding:15px;
}

table td{
    padding:15px;
    border-bottom:1px solid #ddd;
}

/* BARRAS */

.barra{
    width:100%;
    background:#ddd;
    border-radius:20px;
    overflow:hidden;
    height:20px;
}

.progreso{
    height:20px;
    background:linear-gradient(90deg,#00509d,#00b4d8);
}

/* TITULO */

.titulo{
    margin-top:40px;
    margin-bottom:15px;
    color:#003566;
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
Consulta los resultados parciales de las elecciones presidenciales,
municipales y legislativas de Guatemala 2028.
</p>

</div>

<div>

<a href="votar.php" class="btn">
Ir a votar
</a>

</div>

</div>

<!-- STATS -->

<div class="stats">

<div class="stat">
<h3>Total General de Votos</h3>
<h1><?php echo $totalGeneral; ?></h1>
</div>

<?php

$categorias = mysqli_query($con,"
SELECT * FROM tipos_votacion
");

while($cat=mysqli_fetch_assoc($categorias)){

$totalCategoria = $totalesCategoria[$cat['id']] ?? 0;
?>

<div class="stat">

<h3>
<?php echo $cat['nombre']; ?>
</h3>

<h1>
<?php echo $totalCategoria; ?>
</h1>

<p>Votos registrados</p>

</div>

<?php } ?>

</div>

<!-- RESULTADOS -->

<div class="card">

<h2>Resultados Electorales</h2>

<?php

$actual = "";

mysqli_data_seek($candidatos,0);

while($c=mysqli_fetch_assoc($candidatos)){

if($actual != $c['tipo']){

$actual = $c['tipo'];

echo "<h2 class='titulo'>".$actual."</h2>";

echo "
<table>

<tr>
<th>Candidato</th>
<th>Partido</th>
<th>Votos</th>
<th>Porcentaje</th>
</tr>
";
}

$totalCategoria = $totalesCategoria[$c['tipo_id']] ?? 0;

$porcentaje = 0;

if($totalCategoria > 0){
    $porcentaje = ($c['votos'] * 100) / $totalCategoria;
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
<?php echo $c['votos']; ?>
</td>

<td width="350">

<div class="barra">

<div
class="progreso"
style="width: <?php echo $porcentaje; ?>%">
</div>

</div>

<br>

<b>
<?php echo round($porcentaje,2); ?>%
</b>

</td>

</tr>

<?php

$next = mysqli_fetch_assoc($candidatos);

if(!$next || $next['tipo'] != $actual){
    echo "</table><br>";
}

if($next){
    mysqli_data_seek(
        $candidatos,
        mysqli_num_rows($candidatos) - mysqli_num_rows($candidatos) + mysqli_num_rows($candidatos)
    );
}

}

?>

</div>

</div>

</body>
</html>