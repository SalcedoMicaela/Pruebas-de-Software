document.addEventListener("DOMContentLoaded", function (e) {
  e.preventDefault();
  listarUsuarios();
});

document.getElementById("userRegistrerModal").addEventListener("shown.bs.modal", loadRoles);

async function listarUsuarios() {
  try {
    const response = await fetch("./crudPHP/backUsuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "read",
      }),
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const respuesta = await response.text();
    document.getElementById("tabla").innerHTML = respuesta;
  } catch (error) {
    console.error("Error:", error);
  }
}

async function loadRoles() {
  try {
    const response = await fetch("./crudPHP/backUsuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "loadRols",
      }),
    });
    const roles = await response.json();
    const select = document.getElementById("rol");
    select.innerHTML = '';
  
    const defaultOption = document.createElement("option");
    defaultOption.value = '';
    defaultOption.textContent = 'Seleccionar rol';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    select.appendChild(defaultOption);
    
    roles.forEach((role) => {
      const option = document.createElement("option");
      option.value = role.id_rol;
      option.textContent = role.nombre_rol;
      select.appendChild(option);
    });
  } catch (error) {
    console.error("Error:", error);
  }
}

document.getElementById("nombres").addEventListener("input", function () {
  const nombres = this.value;
  const regex = /^[a-zA-Z\s]*$/;
  if (!regex.test(nombres)) {
    this.setCustomValidity("Solo se permiten letras y espacios.");
    this.classList.add("is-invalid");
  } else {
    this.setCustomValidity("");
    this.classList.remove("is-invalid");
  }
});

document.getElementById("apellidos").addEventListener("input", function () {
  const apellidos = this.value;
  const regex = /^[a-zA-Z\s]*$/;
  if (!regex.test(apellidos)) {
    this.setCustomValidity("Solo se permiten letras y espacios.");
    this.classList.add("is-invalid");
  } else {
    this.setCustomValidity("");
    this.classList.remove("is-invalid");
  }
});

// Validación en tiempo real para cédula
document.getElementById("cedula").addEventListener("input", function () {
  const cedula = this.value;
  const regex = /^\d{10,13}$/;
  if (!regex.test(cedula)) {
    this.setCustomValidity("Debe tener entre 10 y 13 dígitos y solo números.");
    this.classList.add("is-invalid");
  } else {
    this.setCustomValidity("");
    this.classList.remove("is-invalid");
  }
});

// Validación en tiempo real para email (Bootstrap lo maneja por defecto)
document.getElementById("email").addEventListener("input", function () {
  if (this.checkValidity()) {
    this.classList.remove("is-invalid");
  } else {
    this.classList.add("is-invalid");
  }
});

// Validación en tiempo real para teléfono
document.getElementById("telefono").addEventListener("input", function () {
  const telefono = this.value;
  const regex = /^\d{10}$/;
  if (!regex.test(telefono)) {
    this.setCustomValidity("El número de teléfono debe tener 10 dígitos.");
    this.classList.add("is-invalid");
  } else {
    this.setCustomValidity("");
    this.classList.remove("is-invalid");
  }
});

// Mostrar/Ocultar contraseña
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordField = document.getElementById("password");
    const passwordFieldType = passwordField.getAttribute("type");
    const passwordToggleButton = this.querySelector("i");

    if (passwordFieldType === "password") {
      passwordField.setAttribute("type", "text");
      passwordToggleButton.classList.remove("bi-eye");
      passwordToggleButton.classList.add("bi-eye-slash");
    } else {
      passwordField.setAttribute("type", "password");
      passwordToggleButton.classList.remove("bi-eye-slash");
      passwordToggleButton.classList.add("bi-eye");
    }
  });
  
document.getElementById("userRegistrerForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    console.log(formData);
    // Convertir FormData a URLSearchParams
    const params = new URLSearchParams({
      action: "create",
      nombres: formData.get("nombres"),
      apellidos: formData.get("apellidos"),
      cedula: formData.get("cedula"),
      email: formData.get("email"),
      username: formData.get("username"),
      password: formData.get("password"),
      telefono: formData.get("telefono"),
      direccion: formData.get("direccion"),
      rol: formData.get("rol"),
    });

    try {
      const response = await fetch("./crudPHP/backUsuarios.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",  // Cambiado a URL encoded
        },
        body: params.toString(),  // `params` convertido a cadena URL
      });

      const result = await response.json();

      if (result.status === "success") {
        alert(result.message);

        // Cerrar el modal usando Bootstrap
        const modalElement = document.getElementById("userRegistrerModal");
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();

        this.reset(); // Limpiar el formulario
      } else {
        alert(result.message);
      }
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while registering the user.");
    }
});



document.getElementById('rolRegistrerForm').addEventListener('submit', async function(e) {
  e.preventDefault(); // Evita el envío del formulario para manejarlo manualmente

  const nombre_rol = document.getElementById('nombre-rol').value.trim();
  const descripcion = document.getElementById('descripcion').value.trim();
  const checkboxes = document.querySelectorAll('#accesos .form-check-input');

  const accesos = [];
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      accesos.push(checkbox.value);
    }
  });

  if (accesos.length === 0) {
    document.getElementById('accesos-error').style.display = 'block';
    return;
  }

  document.getElementById('accesos-error').style.display = 'none';
  const accesosString = accesos.join(',');

  const formData = new URLSearchParams({
    action: 'createRol',
    nombre_rol,
    descripcion,
    accesos: accesosString
  });

  try {
    const response = await fetch('./crudPHP/backUsuarios.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: formData.toString()
    });

    const result = await response.json();

    if (result.success) {
      alert(result.message);
      document.getElementById('rolRegistrerForm').reset(); // Limpiar el formulario
    } else {
      alert(result.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while processing the request.');
  }
});

async function desactivarUsuario(id) {
  try {
    const response = await fetch("./crudPHP/backUsuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "desactive",
        id_usuario: id 
      }),
    });

    const result = await response.json();

    if (result.status == 'success') {
      listarUsuarios();
    } else {
      //alert(result.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while processing the request.');
  }
}
async function activarUsuario(id) {
  try {
    const response = await fetch("./crudPHP/backUsuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "active",
        id_usuario: id 
      }),
    });

    const result = await response.json();

    if (result.status == 'success') {
      listarUsuarios();
    } else {
      //alert(result.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while processing the request.');
  }
}

