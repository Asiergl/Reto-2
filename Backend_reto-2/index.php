<?php
// index.php
// 1. Permitir CORS (para que Vue pueda pedir datos a PHP si están en puertos distintos)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php';

// 2. Obtener la URL y el Método HTTP
$url = isset($_GET['url']) ? $_GET['url'] : '';
$method = $_SERVER['REQUEST_METHOD'];

// Separamos la URL por barras (ej: games/1)
$parts = explode('/', trim($url, '/'));
$resource = isset($parts[0]) ? $parts[0] : '';
$id = isset($parts[1]) ? $parts[1] : null;

// 3. Enrutamiento básico
if ($resource === 'games') {
    if ($method === 'GET') {
        if ($id) {
            // Logica para GET /games/{id} (Lo haremos luego)
            echo json_encode(["mensaje" => "Detalle del juego " . $id]);
        } else {
            // Lógica para GET /games (Listado completo)
            obtenerJuegos($mysqli);
        }
    }
} elseif ($resource === 'events') {
    // Aquí irá la lógica de eventos y paginación
    echo json_encode(["mensaje" => "Aquí irán los eventos"]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
}

// --- FUNCIONES (Idealmente esto iría en otro archivo, pero para empezar lo ponemos aquí) ---

function obtenerJuegos($mysqli) {
    $sql = "SELECT * FROM games";
    
    // Usamos prepare, execute y get_result como pide el enunciado
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // fetch_all devuelve un array asociativo con MYSQLI_ASSOC
    $data = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($data);
}
?>