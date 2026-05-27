<?php
session_start();
require '../includes/conexion.php';

$usuario = $_SESSION['id'];
$candidato = $_POST['candidato'];
$tipo = $_POST['tipo'];

$validar = mysqli_query($con,"SELECT * FROM votos
WHERE usuario_id='$usuario' AND tipo_id='$tipo'");

if(mysqli_num_rows($validar)>0){
    die('Ya votaste en esta categoría');
}

mysqli_query($con,"INSERT INTO votos(usuario_id,candidato_id,tipo_id)
VALUES('$usuario','$candidato','$tipo')");

mysqli_query($con,"UPDATE candidatos SET votos=votos+1
WHERE id='$candidato'");

echo "Voto realizado correctamente";
?>