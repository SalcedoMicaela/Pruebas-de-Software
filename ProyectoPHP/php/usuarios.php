<?php include_once './includes/header.php';?>
<?php
$seccion_actual = 'usuarios';
$accesos_usuario = explode(',', $_SESSION['accesos_usuario']);
if (!in_array($seccion_actual, $accesos_usuario)) {
    header('Location: ./indexAdmin.php');
}
?>
<div class="container"> <h1>Usuarios</h1></div>
<div class="container my-4">
  <!-- Botón para abrir el modal de registro de usuarios -->
  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#userRegistrerModal">Registrar Usuarios</button>

  <!-- Botón para abrir el modal de creación de roles -->
  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#rolRegistrerModal">Añadir Roles</button>
</div>

<!-- Modal de registro de usuarios -->
<div class="modal fade" id="userRegistrerModal" tabindex="-1" aria-labelledby="userRegistrerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="userRegistrerModalLabel">Registro de Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="userRegistrerForm" novalidate>
          <div class="mb-3">
            <label for="nombres" class="col-form-label">Nombres:</label>
            <input type="text" class="form-control" id="nombres" name="nombres" required>
            <div class="invalid-feedback">
              Solo se permiten letras y espacios.
            </div>
          </div>
          <div class="mb-3">
            <label for="apellidos" class="col-form-label">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            <div class="invalid-feedback">
              Solo se permiten letras y espacios.
            </div>
          </div>
          <div class="mb-3">
            <label for="cedula" class="col-form-label">Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" required>
            <div class="invalid-feedback">
              Debe tener entre 10 y 13 dígitos y solo números.
            </div>
          </div>
          <div class="mb-3">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback">
              Ingrese un correo electrónico válido.
            </div>
          </div>
          <div class="mb-3">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="col-form-label">Password:</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" required>
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="telefono" class="col-form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
            <div class="invalid-feedback">
              El número de teléfono debe tener 10 dígitos.
            </div>
          </div>
          <div class="mb-3">
            <label for="direccion" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
          </div>
          <div class="mb-3">
            <label for="rol" class="col-form-label">Rol:</label>
            <select class="form-select" id="rol" name="rol" required>
              <option selected disabled value="">Seleccionar rol</option>
              <!-- <option value="admin">Administrador</option>
              <option value="vendedor">Vendedor</option>
              <option value="bodeguero">Bodeguero</option> -->
            </select>
            <div class="invalid-feedback">
              Seleccione un rol.
            </div>
          </div>
          <div class="container text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de creación de roles -->
<div class="modal fade" id="rolRegistrerModal" tabindex="-1" aria-labelledby="rolRegistrerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="rolRegistrerModalLabel">Añadir Nuevo Rol</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
        <form id="rolRegistrerForm">
          <div class="mb-3">
            <label for="nombre-rol" class="col-form-label">Nombre del Rol:</label>
            <input type="text" class="form-control" id="nombre-rol" name="nombre-rol" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
          </div>
          <div class="mb-3">
            <label for="accesos" class="col-form-label">Accesos:</label>
            <div id="accesos" name="accesos">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="reportes" id="acceso-reportes">
                <label class="form-check-label" for="acceso-reportes">Reportes</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="inventario" id="acceso-inventario">
                <label class="form-check-label" for="acceso-inventario">Inventario</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="ventas" id="acceso-ventas">
                <label class="form-check-label" for="acceso-ventas">Ventas</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="usuarios" id="acceso-usuarios">
                <label class="form-check-label" for="acceso-usuarios">Usuarios</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="clientes" id="acceso-clientes">
                <label class="form-check-label" for="acceso-clientes">Clientes</label>
              </div>
            </div>
            <div id="accesos-error" class="invalid-feedback">
              Debe seleccionar al menos una opción de acceso.
            </div>
          </div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="container table-responsive">
   <table class="table table-striped">
      <thead>
          <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Cedula</th>
          <th>email</th>
          <th>username</th>
          <th>Telefono</th>
          <th>Rol</th>
          <th>Accesos</th>
          <th>estado</th>
          <th>opciones</th>
        </tr>
      </thead>
      <tbody id="tabla">

      </tbody>
  </table>
</div>

<script src="./js/scriptUsuarios.js"></script>
<?php include_once './includes/footer.php';?>
