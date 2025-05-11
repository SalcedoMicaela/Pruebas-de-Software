<?php
include_once 'config.php';

if (isset($_GET['id_factura']) && is_numeric($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    // Obtener los detalles de la factura
    $stmt = $pdo->prepare("SELECT f.*, c.NOMBRE_CLIENTE, c.CEDULA, c.DIRECCION, c.EMAIL, c.TELEFONO 
                           FROM facturas f
                           JOIN clientes c ON f.ID_CLIENTE = c.ID_CLIENTE
                           WHERE f.ID_FACTURA = ?");
    $stmt->execute([$id_factura]);
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$factura) {
        echo "Factura no encontrada.";
        exit();
    }

    // Obtener los detalles de los productos vendidos
    $stmt = $pdo->prepare("SELECT v.*, p.nombre_producto 
                           FROM ventas v
                           JOIN productos p ON v.ID_PRODUCTO = p.id_producto
                           WHERE v.ID_FACTURA = ?");
    $stmt->execute([$id_factura]);
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$ventas) {
        echo "No se encontraron productos para esta factura.";
        exit();
    }
} else {
    echo "ID de factura no proporcionado o inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Venta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Confirmación de Venta</h1>

        <h2>Factura #<?php echo htmlspecialchars($factura['NUMERO_FACTURA'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <p><strong>Fecha de Emisión:</strong> <?php echo htmlspecialchars($factura['FECHA_EMISION'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($factura['NOMBRE_CLIENTE'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Cédula:</strong> <?php echo htmlspecialchars($factura['CEDULA'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($factura['DIRECCION'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($factura['EMAIL'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($factura['TELEFONO'], ENT_QUOTES, 'UTF-8'); ?></p>

        <h3>Productos Vendidos</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['CANTIDAD'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo number_format($venta['PRECIO_UNITARIO'], 2); ?></td>
                    <td><?php echo number_format($venta['SUBTOTAL'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total de la Venta: $<?php echo number_format($factura['MONTO_TOTAL'], 2); ?></h3>
        <p><strong>Estado del Pago:</strong> <?php echo htmlspecialchars($factura['ESTADO_PAGO'], ENT_QUOTES, 'UTF-8'); ?></p>

        <a href="../php/ventas.php" class="btn btn-primary">Regresar a Ventas</a>
    </div>
</body>
</html>
