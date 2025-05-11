
function ListarProductos() {
    fetch("listar.php", {
        method: "POST"
    })
    .then(response => response.text())
    .then(response => {
        document.getElementById('datos_productos').innerHTML = response;
    })
    .catch(error => {
        console.error('Error al listar productos:', error);
    });
}

document.getElementById('frm').addEventListener("submit", function(event) {
    event.preventDefault();  
    fetch("registrar.php", {
        method: "POST",
        body: new FormData(document.getElementById('frm'))
    })
    .then(response => response.text())
    .then(response => {
        if (response === "ok") {
            Swal.fire({
                icon: "error",
                title: "Producto registrado con éxito!!",
                showConfirmButton: false,
                timer: 1500
            });
            
        }else {
                    
					Swal.fire({
                        icon: 'success',
                          title: "Producto registrado con éxito!!",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }document.getElementById('frm').reset();  
            ListarProductos(); 
		resetButton(); 
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error durante el proceso de registro.",
        });
    });
});


function Eliminar(id, estadoActual) {
    // Determinar la acción basada en el estado actual
    const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';

    // Mostrar confirmación al usuario
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} el producto?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar la solicitud al servidor
            fetch('eliminar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id, estado: estadoActual })
            })
            .then(response => response.text())
            .then(response => {
                if (response === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Error',
                        text: 'Ocurrió un error al cambiar el estado.',
                    });
                   
                    ListarProductos();
                } else {
                    
					Swal.fire({
                        icon: 'success',
                        title: `Producto ${nuevoEstado === 'activo' ? 'desactivado' : 'activado'} con éxito!`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } ListarProductos();  
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error durante la solicitud.',
                });
            });
        }
    });
}



function Editar(id) {
    fetch("editar.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'  
        },
        body: JSON.stringify({ id: id })  
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(response => {
        console.log(response);  
        if (response) {
		    document.getElementById('idp').value = response.id_producto || '';
            document.getElementById('nombre').value = response.nombre_producto || '';
            document.getElementById('descripcion').value = response.descripcion || '';
            document.getElementById('precio_unitario').value = response.precio_unitario || '';
            document.getElementById('categoria').value = response.categoria || '';
            document.getElementById('stock').value = response.stock || '';
            document.getElementById('estado').value = response.estado || '';
            document.getElementById('tipo_impuesto').value = response.producto_iva_rise || '';
            document.getElementById('valor_impuesto').value = response.valor_iva_risa || '';
			document.getElementById('registrar').value = 'Actualizar';
        } else {
            alert("Error: No se encontraron los datos del producto.");
        }
    })
    .catch(error => {
        console.error('Error al editar el producto:', error);
        alert("Hubo un problema al cargar los datos del producto. Por favor, intenta nuevamente.");
    });
}
function resetButton() {
    document.getElementById('registrar').value = 'Enviar datos';
}
document.addEventListener("DOMContentLoaded", ListarProductos);



document.getElementById("precio_unitario").addEventListener("keypress", function(event) {
    var charCode = event.which ? event.which : event.keyCode;
    var inputValue = this.value;

    // Permitir solo números (0-9), punto (.) y coma (,)
    if ((charCode < 48 || charCode > 57) && charCode !== 46 && charCode !== 44) {
        event.preventDefault();
    }

    // Bloquear más de un punto o coma
    if ((charCode === 46 || charCode === 44) && (inputValue.includes('.') || inputValue.includes(','))) {
        event.preventDefault();
    }
});

document.getElementById("precio_unitario").addEventListener("input", function() {
    var precio = this.value;
    var regexPrecio = /^[0-9]+([.,][0-9]{0,8})?$/;
    var precioError = document.getElementById("precioError");

    if (!regexPrecio.test(precio)) {
        precioError.textContent = "El precio solo puede contener números, y opcionalmente un punto o coma.";
    } else {
        precioError.textContent = "";
    }
});





document.getElementById("stock").addEventListener("keypress", function(event) {
    // Obtener el código de la tecla presionada
    var charCode = event.which ? event.which : event.keyCode;

    // Permitir solo números (0-9)
    if (charCode < 48 || charCode > 57) {
        event.preventDefault();  // Bloquear el carácter si no es un número
    }
});

document.getElementById("stock").addEventListener("input", function() {
    // Validar que el valor no tenga más de 4 dígitos
    var stock = this.value;
    var stockError = document.getElementById("stockError");
    
    if (stock.length > 4) {
        stockError.textContent = "El stock solo puede contener números enteros de hasta 4 dígitos.";
        this.value = stock.slice(0, 4);  // Limitar a 4 dígitos
    } else {
        stockError.textContent = "";
    }
});


document.getElementById("valor_impuesto").addEventListener("keypress", function(event) {
    // Obtener el código de la tecla presionada
    var charCode = event.which ? event.which : event.keyCode;

    // Permitir solo números (0-9)
    if (charCode < 48 || charCode > 57) {
        event.preventDefault();  // Bloquear el carácter si no es un número
    }
});

document.getElementById("valor_impuesto").addEventListener("input", function() {
    // Validar que el valor no tenga más de 2 dígitos
    var valorImpuesto = this.value;
    var precioError = document.getElementById("precioError2");
    
    if (valorImpuesto.length > 2) {
        precioError.textContent = "El impuesto solo puede contener números enteros de hasta 2 dígitos.";
        this.value = valorImpuesto.slice(0, 2);  // Limitar a 2 dígitos
    } else {
        precioError.textContent = "";
    }
});



document.getElementById("tipo_impuesto").addEventListener("change", function() {
    var tipoImpuesto = this.value;
    var valorImpuestoInput = document.getElementById("valor_impuesto");
    var labelValorImpuesto = document.getElementById("label_valor_impuesto");

    if (tipoImpuesto === "sinImpuesto") {
        // Desactivar el input y el label cuando seleccionan "Sin Impuesto"
        valorImpuestoInput.value = "0";
        valorImpuestoInput.disabled = true;
        labelValorImpuesto.style.display = "none";
    } else {
        // Activar el input y el label para "IVA" o "RISE"
        valorImpuestoInput.disabled = false;
        valorImpuestoInput.value = "";  // Limpiar el valor para que el usuario lo ingrese
        labelValorImpuesto.style.display = "block";
    }
});



















