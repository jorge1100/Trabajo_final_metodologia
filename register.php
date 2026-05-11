<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/session.php';

$conexion = new mysqli("localhost", "root", "", "trabajo_final_metodologia");
if ($conexion->connect_error) {
    die("Error de conexión");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: auth_view.php");
    exit;
}

if (
    empty($_POST['usuario']) ||
    empty($_POST['correo']) ||
    empty($_POST['password'])
) {
    header("Location: auth_view.php?error=campos_vacios");
    exit;
}

$usuario = trim($_POST['usuario']);
$correo  = trim($_POST['correo']);
$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conexion->prepare(
    "INSERT INTO usuarios (nombre_usuario, correo_electronico, hash_contrasena)
     VALUES (?, ?, ?)"
);

if (!$stmt) {
    die("Error prepare: " . $conexion->error);
}

$stmt->bind_param("sss", $usuario, $correo, $passwordHash);
$stmt->execute();

header("Location: auth_view.php?registro=ok");
exit;