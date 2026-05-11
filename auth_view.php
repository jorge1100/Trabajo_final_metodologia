<?php
$vista = $_GET['vista'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="auth-container">

  <div class="auth-tabs">
    <a href="auth_view.php?vista=login" class="tab-btn <?= $vista === 'login' ? 'active' : '' ?>">
      Iniciar sesión
    </a>
    <a href="auth_view.php?vista=registro" class="tab-btn <?= $vista === 'registro' ? 'active' : '' ?>">
      Registrarse
    </a>
  </div>

  <?php if ($vista === 'login'): ?>
    <!-- LOGIN -->
    <div class="auth-card">
      <h2>Iniciar sesión</h2>

      <form method="post" action="login.php">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
      </form>
    </div>
  <?php else: ?>
    <!-- REGISTRO -->
    <div class="auth-card">
      <h2>Crear cuenta</h2>

      <form method="post" action="register.php">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
      </form>
    </div>
  <?php endif; ?>

</div>

</body>
</html>