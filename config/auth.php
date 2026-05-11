
<?php
require_once __DIR__ . '/session.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: auth_view.php");
    exit;
}
