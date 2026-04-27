<?php
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "trabajo_final_metodologia");
$id_usuario = 1;

$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

/* ========================= */
switch ($accion) {

  case 'listar':
    $sql = "SELECT id_nota, titulo_nota, contenido_nota
            FROM notas
            WHERE id_usuario = ? AND nota_archivada = 0
            ORDER BY id_nota DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();

    $res = $stmt->get_result();
    $notas = [];

    while ($row = $res->fetch_assoc()) {
      $notas[] = [
        'id' => $row['id_nota'],
        'titulo' => $row['titulo_nota'],
        'contenido' => $row['contenido_nota']
      ];
    }

    echo json_encode(['notas' => $notas]);
    break;

  /* ========================= */
  case 'agregar':
    $sql = "INSERT INTO notas (id_usuario, titulo_nota, contenido_nota, nota_archivada)
            VALUES (?, ?, ?, 0)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $id_usuario, $_POST['titulo'], $_POST['contenido']);
    $stmt->execute();

    echo json_encode(['exito' => true]);
    break;

  /* ========================= */
  case 'editar':
    $sql = "UPDATE notas
            SET titulo_nota = ?, contenido_nota = ?, fecha_modificacion = NOW()
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

    echo json_encode(['exito' => true]);
    break;

  /* ========================= */
  case 'eliminar':
    $sql = "UPDATE notas
            SET nota_archivada = 1
            WHERE id_nota = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $_POST['id'], $id_usuario);
    $stmt->execute();

    echo json_encode(['exito' => true]);
    break;
}