<?php include_once './includes/header.php'; ?>
<?php 
$seccion_actual = 'inventario'; 
$accesos_usuario = explode(',', $_SESSION['accesos_usuario']);
if (!in_array($seccion_actual, $accesos_usuario)) {
    header('Location: ./indexAdmin.php');
}
?>
<div class="container form-container">
    <h1>Inventario</h1>
    <form id="frm" method="post">
        <div class="row">
       
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
					<input type="hidden" name="idp" id="idp" value="">
                    <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Nombre del producto">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" rows="1" id="descripcion" name="descripcion" placeholder="Descripción" required></textarea>
                </div>
                <div class="form-group">
    <label for="precio_unitario">Precio Unitario:</label>
    <input type="text" name="precio_unitario" id="precio_unitario" class="form-control" placeholder="Precio unitario" required>
    <span id="precioError" style="color: red;"></span> <!-- Mensaje de error -->
</div>

                <div class="form-group">
                    <p>&nbsp;</p>
                    <p>
                        <input type="submit" class="btn btn-dark" name="registrar" id="registrar" value="Enviar datos">
                    </p>
                </div>
            </div>
            <!-- Segunda columna -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="categoria">Categoría del Producto:</label>
                    <select class="form-select" id="categoria" placeholder="Categoría" name="categoria" required>
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <option value="cuidaoP">Cuidado de la piel</option>
                        <option value="cuidadoC">Cuidado del Cabello</option>
                        <option value="maquillaje">Maquillaje</option>
                    </select>
                </div>
                <div class="form-group">
    <label for="stock">Stock:</label>
    <input type="text" name="stock" placeholder="Stock" id="stock" class="form-control" required>
    <span id="stockError" style="color: red;"></span> <!-- Mensaje de error -->
</div>


                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select class="form-select" id="estado" placeholder="Estado" name="estado" required>
                        <option value="" disabled selected>Seleccione un estado</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <!-- Tercera columna -->
           <div class="col-md-5">
    <div class="form-group">
        <label for="tipo_impuesto">Tipo de Impuesto:</label>
        <select class="form-select" id="tipo_impuesto" placeholder="Tipo de impuesto" name="tipo_impuesto" required>
            <option value="" disabled selected>Seleccione un tipo de impuesto</option>
            <option value="sinImpuesto">Sin Impuesto</option>
            <option value="iva">IVA</option>
            <option value="rise">RISE</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="valor_impuesto">Valor del IVA/RISE:</label>
        <input type="text" name="valor_impuesto" placeholder="Valor del impuesto" id="valor_impuesto" class="form-control" >
        <span id="precioError2" style="color: red; display: block; margin-top: 5px;"></span>
    </div>
</div>

        </div>
    </form>
</div>

<!-- Nueva fila para la tabla -->
<div class="container table-responsive">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Categoría</th>
                        <th>Tipo de Impuesto</th>
                        <th>Valor del Impuesto</th>
						<th>PVP</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="datos_productos">
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="funciones.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include_once './includes/footer.php'; ?>
	
