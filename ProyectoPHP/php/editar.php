<?php
// Decodificar los datos enviados desde el fetch en JSON
$data = json_decode(file_get_contents('php://input'), true);

require_once "crud.php";
$query = $pdo->prepare("SELECT * FROM productos WHERE id_producto = :id");
$query->bindParam(":id", $data['id'], PDO::PARAM_INT);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    echo json_encode($resultado);
} else {
    echo json_encode([]);
}
?>


