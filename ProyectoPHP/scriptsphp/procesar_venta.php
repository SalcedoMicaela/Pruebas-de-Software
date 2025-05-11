<?php
include_once 'config.php'; // Conexión a la base de datos

// Obtener datos del formulario
$idCliente = $_POST['id_cliente'];
$estadoPago = $_POST['estado_pago'];
$totalVenta = $_POST['totalVenta'];
$productos = json_decode($_POST['productos'], true); // Decodificar el JSON de productos

// Imprimir los datos recibidos para depuración
echo "<pre>";
echo "ID Cliente: " . htmlspecialchars($idCliente) . "\n";
echo "Estado de Pago: " . htmlspecialchars($estadoPago) . "\n";
echo "Total Venta: " . htmlspecialchars($totalVenta) . "\n";
echo "Productos: \n";
print_r($productos);
echo "</pre>";

// Comenzar la transacción
$conn->begin_transaction();

try {
    $numeroFactura = 'FAC-' . uniqid(); // Generar un número de factura único

    // Insertar datos en la tabla `facturas`
    $stmt = $conn->prepare("INSERT INTO facturas (ID_CLIENTE, NUMERO_FACTURA, FECHA_EMISION, MONTO_TOTAL, ESTADO_PAGO) VALUES (?, ?, NOW(), ?, ?)");
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta para facturas: " . $conn->error);
    }

    $stmt->bind_param('ssis', $idCliente, $numeroFactura, $totalVenta, $estadoPago);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta para facturas: " . $stmt->error);
    }

    $idFactura = $stmt->insert_id; // Obtener el ID de la factura insertada

    // Insertar datos en la tabla `detalles_venta`
    $stmt = $conn->prepare("INSERT INTO detalles_venta (ID_PRODUCTO, ID_FACTURA, CODIGO_PRODUCTO, CANTIDAD, PRECIO_UNITARIO, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta para detalles de venta: " . $conn->error);
    }

    foreach ($productos as $producto) {
        $stmt->bind_param("iissdd", $producto['id_producto'], $idFactura, $producto['codigo_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['subtotal']);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta para detalles de venta: " . $stmt->error);
        }
    }

    // Confirmar la transacción
    $conn->commit();
    echo "Venta procesada exitosamente.";

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error al procesar la venta: " . $e->getMessage();
}

// Cerrar la conexión
$conn->close();
?>
