<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
  <link rel="stylesheet" href="./css/estilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
  <symbol id="check-circle-fill" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<body>
  
  <div class="container-form">
    <form action="./scriptsphp/login.php" method="POST" id="loginForm" class="form-control bg-body-secondary">
      <div class="container-fluid text-center">
        <img class="mb-4" src="./img/logo3.png" alt="" width="90" height="57">
      </div>
      <h1 class="h3 mb-3 fw-normal">Inicio de sesion</h1>
      <div class="alert alert-danger d-flex align-items-center d-none" role="alert" id="alertLogin">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="30" height="30"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
          Usuario o contraseña incorrecto
        </div>
      </div>
      

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        <label for="username">Usuario</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Password">
        <label for="passwordLogin">Contraseña</label>
      </div>
      <button class="btn btn-dark w-100 py-2" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-body-secondary text-center" >© 2024</p>
    </form>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
  </div>



<!-- <div class="modal fade" id="secretModal" tabindex="-1" aria-labelledby="secretModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="secretModalLabel">Crear Super Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="superUserForm">
          <div class="mb-3">
            <label for="super-username" class="form-label">Usuario:</label>
            <input type="text" class="form-control" id="super-username" required>
          </div>
          <div class="mb-3">
            <label for="super-password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="super-password" required>
          </div>
          <button type="submit" class="btn btn-primary">Registrar Super Usuario</button>
        </form>
      </div>
    </div>
  </div>
</div> -->
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="./scriptsJs/login.js"></script>
</body>

</html>