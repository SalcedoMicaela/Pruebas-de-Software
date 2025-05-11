<?php
include_once 'config.php';

$query = $_POST['query'];
$sql = "SELECT ID_CLIENTE, NOMBRE_CLIENTE, CEDULA, DIRECCION, EMAIL, TELEFONO FROM clientes WHERE CEDULA LIKE ? OR NOMBRE_CLIENTE LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<div class="select-cliente" data-id="' . $row['ID_CLIENTE'] . '" data-nombre="' . $row['NOMBRE_CLIENTE'] . '" data-cedula="' . $row['CEDULA'] . '" data-direccion="' . $row['DIRECCION'] . '" data-email="' . $row['EMAIL'] . '" data-telefono="' . $row['TELEFONO'] . '">' . $row['NOMBRE_CLIENTE'] . '</div>';
}
?>
