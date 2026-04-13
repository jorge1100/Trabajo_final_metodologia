<?php
header('Content-Type: application/json');

// En una aplicación real esto usaría una base de datos
// Por simplicidad, usamos un archivo JSON
$archivo_notas = 'notas.json';

// Inicializar el archivo si no existe
if (!file_exists($archivo_notas)) {
    file_put_contents($archivo_notas, json_encode(['notas' => []]));
}

// Cargar las notas
$datos = json_decode(file_get_contents($archivo_notas), true);

// Determinar la acción a realizar
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if (empty($accion) && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
}

switch ($accion) {
    case 'listar':
        echo json_encode($datos);
        break;
        
    case 'agregar':
        if (isset($_POST['titulo']) && isset($_POST['contenido'])) {
            $nuevaNota = [
                'id' => time(), // Usar timestamp como ID simple
                'titulo' => $_POST['titulo'],
                'contenido' => $_POST['contenido'],
                'fecha' => date('Y-m-d H:i:s')
            ];
            
            $datos['notas'][] = $nuevaNota;
            file_put_contents($archivo_notas, json_encode($datos));
            
            echo json_encode(['exito' => true]);
        } else {
            echo json_encode(['exito' => false, 'error' => 'Datos incompletos']);
        }
        break;
        
    case 'eliminar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $nuevasNotas = [];
            
            foreach ($datos['notas'] as $nota) {
                if ($nota['id'] != $id) {
                    $nuevasNotas[] = $nota;
                }
            }
            
            $datos['notas'] = $nuevasNotas;
            file_put_contents($archivo_notas, json_encode($datos));
            
            echo json_encode(['exito' => true]);
        } else {
            echo json_encode(['exito' => false, 'error' => 'ID no proporcionado']);
        }
        break;
        
    default:
        echo json_encode(['exito' => false, 'error' => 'Acción desconocida']);
}
?>