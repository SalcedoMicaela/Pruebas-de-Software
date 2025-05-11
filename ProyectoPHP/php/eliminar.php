<?php
require_once  "crud.php";

// Leer los datos JSON enviados
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$estado = $data['estado'];

// Determinar el nuevo estado
$nuevoEstado = $estado === 'activo' ? 'inactivo' : 'activo';

try {
    $query = $pdo->prepare("UPDATE productos SET estado = :estado WHERE id_producto = :id");
    $query->bindParam(':estado', $nuevoEstado);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        echo "ok"; // Respuesta exitosa
    } else {
        echo "error"; // Respuesta de error
    }
} catch (PDOException $e) {
    echo "error"; // Respuesta de error
}
?>



