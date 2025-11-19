<?php

require_once "db.php";   // Importa la conexión PDO ($conn)

class Modelo {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ====================================================
    // CREATE – Insertar registro
    // ====================================================
    public function crearUsuario($nombre, $email, $password)
    {
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    // ====================================================
    // READ – Obtener todos los registros
    // ====================================================
    public function obtenerUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // ====================================================
    // READ – Obtener un solo registro por ID
    // ====================================================
    public function obtenerUsuarioPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // ====================================================
    // UPDATE – Actualizar registro
    // ====================================================
    public function actualizarUsuario($id, $nombre, $email)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':email' => $email
        ]);
    }

    // ====================================================
    // DELETE – Eliminar registro
    // ====================================================
    public function eliminarUsuario($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}

// Instancia del modelo
$modelo = new Modelo($conn);

?>

