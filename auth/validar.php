<?php
session_start();
require '../includes/conexion.php';

$correo = $_POST['correo'];
$password = md5($_POST['password']);

$sql = mysqli_query($con,"SELECT * FROM usuarios WHERE correo='$correo' AND password='$password'");

if(mysqli_num_rows($sql)>0){

    $user = mysqli_fetch_assoc($sql);

    $_SESSION['id'] = $user['id'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['rol'] = $user['rol'];

    if($user['rol']=='admin'){
        header('Location: ../admin/dashboard.php');
    }else{
        header('Location: ../voter/dashboard.php');
    }

}else{
    echo "Credenciales incorrectas";
}
?>