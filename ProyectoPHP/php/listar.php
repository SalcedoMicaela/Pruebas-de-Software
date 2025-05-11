<?php
require_once "crud.php";

$consulta = $pdo->prepare("SELECT * FROM productos ORDER BY id_producto DESC");
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultado as $data) {
    // Calcula el PVP basado en la condición

        $pv = $data['precio_unitario'] * $data['valor_iva_risa']/100;
		$pvp = $data['precio_unitario'] + $pv;
    

    // Determina el texto y la clase del botón basado en el estado del producto
    $estado = $data['estado'] == 'activo' ? 'Desactivar' : 'Activar';
    $buttonClass = $data['estado'] == 'activo' ? 'btn btn-danger' : 'btn btn-success';
    $buttonText = $estado;

    echo "<tr>
            <td>".$data['id_producto']."</td>
            <td>".$data['nombre_producto']."</td>
            <td>".$data['descripcion']."</td>
            <td>".$data['precio_unitario']."</td>
            <td>".$data['stock']."</td>
            <td>".$data['estado']."</td>
            <td>".$data['categoria']."</td>
            <td>".$data['producto_iva_rise']."</td>
            <td>".$data['valor_iva_risa']."</td>
            <td>".$pvp."</td> <!-- Muestra el PVP calculado -->
            <td>
                <button type='button' class='btn btn-primary' onclick=Editar('".$data['id_producto']."')>Editar</button>
                <button type='button' class='".$buttonClass."' onclick='Eliminar(".$data['id_producto'].", \"".$data['estado']."\")'>".$buttonText."</button>
            </td>
          </tr>";
}
?>





