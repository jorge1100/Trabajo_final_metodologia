<?php
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "trabajo_final_metodologia");
if ($conexion->connect_error) {
  echo json_encode(["error" => "Error de conexión"]);
  exit;
}

$id_usuario = 1;
$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

/* ========================= */
switch ($accion) {

  /* ==== LISTAR ==== */
  case 'listar':

    $guardadas = [];
    $archivadas = [];

    $sql = "SELECT id_nota, titulo_nota, contenido_nota, nota_archivada
            FROM notas
            WHERE id_usuario = ?
            ORDER BY id_nota DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
      $nota = [
        "id" => $row["id_nota"],
        "titulo" => $row["titulo_nota"],
        "contenido" => $row["contenido_nota"]
      ];

      if ($row["nota_archivada"] == 0) {
        $guardadas[] = $nota;
      } else {
        $archivadas[] = $nota;
      }
    }

    echo json_encode([
      "guardadas" => $guardadas,
      "archivadas" => $archivadas
    ]);
    break;

  /* ==== AGREGAR ==== */
  case 'agregar':
    $sql = "INSERT INTO notas (id_usuario, titulo_nota, contenido_nota, nota_archivada)
            VALUES (?, ?, ?, 0)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $id_usuario, $_POST['titulo'], $_POST['contenido']);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    break;

  /* ==== EDITAR ==== */
  case 'editar':
    $sql = "UPDATE notas
            SET titulo_nota = ?, contenido_nota = ?
            WHERE id_nota = ? AND id_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
      "ssii",
      $_POST['titulo'],
      $_POST['contenido'],
      $_POST['id'],
      $id_usuario
    );
    $stmt->execute();

    echo json_encode(["ok" => true]);
    break;

  /* ==== ARCHIVAR ==== */
  case 'eliminar':
    $sql = "UPDATE notas
            SET nota_archivada = 1
            WHERE id_nota = ? AND id_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $_POST['id'], $id_usuario);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    break;

  /* ==== BORRAR DEFINITIVO ==== */
  case 'borrar':
    $sql = "DELETE FROM notas WHERE id_nota = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $_POST['id'], $id_usuario);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    break;
}
