<?php

header("Content-Type: application/json");

// Cargar modelo y DB
require_once "modelo.php";

// Método HTTP recibido
$method = $_SERVER["REQUEST_METHOD"];

// Obtener datos enviados (JSON en POST/PUT)
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    // ====================================================
    // GET - Obtener todos o uno
    // ====================================================
    case "GET":
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $resultado = $modelo->obtenerUsuarioPorId($id);
        } else {
            $resultado = $modelo->obtenerUsuarios();
        }

        echo json_encode($resultado);
        break;

    // ====================================================
    // POST - Crear usuario
    // ====================================================
    case "POST":
        if (!isset($input['nombre']) || !isset($input['email']) || !isset($input['password'])) {
            echo json_encode(["error" => "Faltan datos"]);
            break;
        }

        $ok = $modelo->crearUsuario(
            $input['nombre'],
            $input['email'],
            $input['password']
        );

        echo json_encode(["success" => $ok]);
        break;

    // ====================================================
    // PUT - Actualizar usuario
    // ====================================================
    case "PUT":
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID requerido"]);
            break;
        }

        $id = intval($_GET['id']);

        $ok = $modelo->actualizarUsuario(
            $id,
            $input['nombre'] ?? null,
            $input['email'] ?? null
        );

        echo json_encode(["success" => $ok]);
        break;

    // ====================================================
    // DELETE - Eliminar usuario
    // ====================================================
    case "DELETE":
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID requerido"]);
            break;
        }

        $id = intval($_GET['id']);
        $ok = $modelo->eliminarUsuario($id);

        echo json_encode(["success" => $ok]);
        break;

    // ====================================================
    // MÉTODO NO PERMITIDO
    // ====================================================
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

?>
