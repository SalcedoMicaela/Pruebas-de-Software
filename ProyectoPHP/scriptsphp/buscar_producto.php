<?php
include_once 'config.php';

$query = $_POST['query'];
$sql = "SELECT id_producto, nombre_producto, descripcion, precio_unitario FROM productos WHERE nombre_producto LIKE ? OR id_producto LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<div class="select-producto" data-id="' . $row['id_producto'] . '" data-nombre="' . $row['nombre_producto'] . '" data-descripcion="' . $row['descripcion'] . '" data-precio="' . $row['precio_unitario'] . '">' . $row['nombre_producto'] . '</div>';
}
?>
