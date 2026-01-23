<?php
// index.php
// 1. CORS y Cabeceras
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php';

// 2. Obtener URL y Método
$url = isset($_GET['url']) ? $_GET['url'] : '';
$method = $_SERVER['REQUEST_METHOD'];

$parts = explode('/', trim($url, '/'));
$resource = isset($parts[0]) ? $parts[0] : '';
$id = isset($parts[1]) ? $parts[1] : null;

// 3. ENRUTAMIENTO PRINCIPAL
if ($resource === 'games') {
    if ($method === 'GET') {
        if ($id) {
            echo json_encode(["mensaje" => "Detalle del juego " . $id]);
        } else {
            obtenerJuegos($mysqli);
        }
    }
} elseif ($resource === 'events') {
    // =======================================================
    // FÍJATE AQUÍ: YA NO ESTÁ EL MENSAJE DE TEXTO
    // AHORA LLAMAMOS A LA FUNCIÓN DIRECTAMENTE
    // =======================================================
    if ($method === 'GET') {
        if ($id) {
            echo json_encode(["mensaje" => "Detalle del evento " . $id]);
        } else {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            obtenerEventos($mysqli, $page);
        }
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
}

// --- FUNCIONES ---

function obtenerJuegos($mysqli) {
    $sql = "SELECT * FROM games";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
}

function obtenerEventos($mysqli, $page) {
    // Validación de página
    if ($page < 1) $page = 1;

    $limit = 9; 
    $offset = ($page - 1) * $limit;
    
    // Consulta Paginada
    $sql = "SELECT * FROM events ORDER BY fecha ASC, hora ASC LIMIT ? OFFSET ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data);
}
?>