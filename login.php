<?php
require_once __DIR__ . '/config/session.php';

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "trabajo_final_metodologia");
if ($conexion->connect_error) {
    die("Error de conexión");
}

// Verificar que venga del formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: auth_view.php");
    exit;
}

// Validar campos obligatorios
if (
    empty($_POST['usuario']) ||
    empty($_POST['password'])
) {
    header("Location: auth_view.php?error=campos_vacios");
    exit;
}

$usuario  = trim($_POST['usuario']);
$password = $_POST['password'];

// Buscar el usuario
$stmt = $conexion->prepare(
    "SELECT id_usuario, hash_contrasena
     FROM usuarios
     WHERE nombre_usuario = ?"
);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si existe el usuario
if ($resultado->num_rows !== 1) {
    header("Location: auth_view.php?error=login");
    exit;
}

$fila = $resultado->fetch_assoc();

// Verificar contraseña
if (!password_verify($password, $fila['hash_contrasena'])) {
    header("Location: auth_view.php?error=login");
    exit;
}

// ✅ Login correcto → crear sesión
$_SESSION['id_usuario'] = $fila['id_usuario'];

// Redirigir al sistema de notas
header("Location: index.php");
exit;