<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="main">

<div class="card">
<h1>Bienvenido <?php echo $_SESSION['nombre']; ?></h1>
<a href="votar.php">
<button>Ir a votar</button>
</a>
</div>

</div>

</body>
</html>