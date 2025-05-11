<?php include_once './includes/header.php'; ?>
<?php 
$seccion_actual = 'ventas'; 
$accesos_usuario = explode(',', $_SESSION['accesos_usuario']);
if (!in_array($seccion_actual, $accesos_usuario)) {
    header('Location: ./indexAdmin.php');
}
?>
<div class="container">
  <h1>Realizar Venta</h1>
 


  <form id="ventaForm" action="../scriptsphp/procesar_venta.php" method="post">
    <div class="row">
      <div class="col-md-6">
        <input type="hidden" id="idCliente" name="id_cliente">

        <h3>Datos del Cliente</h3>
        <div class="form-group">
          <label for="busquedaCliente">Buscar Cliente (Cédula o Nombre):</label>
          <input type="text" id="busquedaCliente" name="busquedaCliente" class="form-control" autocomplete="off">
          <div id="resultadosClientes"></div>
        </div>
        <div class="form-group">
          <label for="clienteNombre">Nombre:</label>
          <input type="text" id="clienteNombre" name="clienteNombre" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="clienteCedula">Cédula:</label>
          <input type="text" id="clienteCedula" name="clienteCedula" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="clienteDireccion">Dirección:</label>
          <input type="text" id="clienteDireccion" name="clienteDireccion" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="clienteEmail">Email:</label>
          <input type="email" id="clienteEmail" name="clienteEmail" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="clienteTelefono">Teléfono:</label>
          <input type="text" id="clienteTelefono" name="clienteTelefono" class="form-control" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Productos</h3>
        <div class="form-group">
          <label for="busquedaProducto">Buscar Producto (ID o Nombre):</label>
          <input type="text" id="busquedaProducto" name="busquedaProducto" class="form-control" autocomplete="off">
          <div id="resultadosProductos"></div>
        </div>
        <input type="hidden" id="idProducto" name="id_producto">
        <div class="form-group">
          <label for="productoNombre">Nombre:</label>
          <input type="text" id="productoNombre" name="productoNombre" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="productoDescripcion">Descripción:</label>
          <textarea id="productoDescripcion" name="productoDescripcion" class="form-control" readonly></textarea>
        </div>
        <div class="form-group">
          <label for="productoPrecio">Precio Unitario:</label>
          <input type="text" id="productoPrecio" name="productoPrecio" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="cantidadProducto">Cantidad:</label>
          <input type="number" id="cantidadProducto" name="cantidadProducto" class="form-control" min="1" required>
        </div>
        <button type="button" id="añadirProducto" class="btn btn-primary">Añadir Producto</button>
        
        <h3>Productos Añadidos</h3>
        <table class="table" id="tablaProductos">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio Unitario</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Filas de productos añadidos se generarán aquí -->
          </tbody>
        </table>
        
        <h3>Total</h3>
        <div class="form-group">
          <label for="totalVenta">Total:</label>
          <input type="text" id="totalVenta" name="totalVenta" class="form-control" readonly>
        </div>

        <!-- Campo oculto para el estado del pago -->
        <input type="hidden" id="estadoPago" name="estado_pago" value="Pendiente">

        <button type="submit" class="btn btn-success">Finalizar Venta</button>
      </div>
    </div>
  </form>
</div>
<?php include_once './includes/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../scriptsJs/busquedas.js"></script>
