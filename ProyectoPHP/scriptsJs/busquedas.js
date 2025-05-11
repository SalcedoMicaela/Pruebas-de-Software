$(document).ready(function() {
    // Buscar clientes
    $('#busquedaCliente').on('input', function() {
        var query = $(this).val();
        if (query.length >= 3) { // Solo buscar si hay al menos 3 caracteres
            $.ajax({
                url: '../scriptsphp/buscar_cliente.php',
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#resultadosClientes').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error al buscar cliente:', error);
                }
            });
        } else {
            $('#resultadosClientes').html('');
        }
    });

    // Seleccionar cliente
    $(document).on('click', '.select-cliente', function() {
        var idCliente = $(this).data('id');
        var nombreCliente = $(this).data('nombre');
        var cedulaCliente = $(this).data('cedula');
        var direccionCliente = $(this).data('direccion');
        var emailCliente = $(this).data('email');
        var telefonoCliente = $(this).data('telefono');
        
        // Añadir console logs para depuración
        console.log("ID Cliente seleccionado:", idCliente);
        console.log("Nombre Cliente:", nombreCliente);
        console.log("Cédula Cliente:", cedulaCliente);
        console.log("Dirección Cliente:", direccionCliente);
        console.log("Email Cliente:", emailCliente);
        console.log("Teléfono Cliente:", telefonoCliente);
        
        $('#idCliente').val(idCliente);
        $('#clienteNombre').val(nombreCliente);
        $('#clienteCedula').val(cedulaCliente);
        $('#clienteDireccion').val(direccionCliente);
        $('#clienteEmail').val(emailCliente);
        $('#clienteTelefono').val(telefonoCliente);
        
        $('#resultadosClientes').html('');
    });

    // Buscar productos
    $('#busquedaProducto').on('input', function() {
        var query = $(this).val();
        if (query.length >= 3) { // Solo buscar si hay al menos 3 caracteres
            $.ajax({
                url: '../scriptsphp/buscar_producto.php',
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#resultadosProductos').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error al buscar producto:', error);
                }
            });
        } else {
            $('#resultadosProductos').html('');
        }
    });

    // Seleccionar producto
    $(document).on('click', '.select-producto', function() {
        var idProducto = $(this).data('id');
        var nombreProducto = $(this).data('nombre');
        var descripcionProducto = $(this).data('descripcion');
        var precioProducto = $(this).data('precio');
        
        // Verifica que estos valores están correctos
        console.log("ID Producto al seleccionar:", idProducto);
        console.log("Nombre Producto:", nombreProducto);
        console.log("Descripción Producto:", descripcionProducto);
        console.log("Precio Producto:", precioProducto);
        
        $('#productoNombre').val(nombreProducto);
        $('#productoDescripcion').val(descripcionProducto);
        $('#productoPrecio').val(precioProducto);
        $('#idProducto').val(idProducto);
        
        $('#resultadosProductos').html('');
    });

    // Añadir producto a la tabla
    $('#añadirProducto').on('click', function() {
        var idProducto = $('#idProducto').val();
        var nombreProducto = $('#productoNombre').val();
        var descripcionProducto = $('#productoDescripcion').val();
        var precioProducto = parseFloat($('#productoPrecio').val());
        var cantidadProducto = parseInt($('#cantidadProducto').val());

        console.log("ID Producto:", idProducto);
        console.log("Nombre Producto:", nombreProducto);
        console.log("Descripción Producto:", descripcionProducto);
        console.log("Precio Producto:", precioProducto);
        console.log("Cantidad Producto:", cantidadProducto);

        if (idProducto && nombreProducto && descripcionProducto && cantidadProducto > 0) {
            var subtotal = precioProducto * cantidadProducto;
            $('#tablaProductos tbody').append(
                '<tr>' +
                '<td class="id-producto">' + idProducto + '</td>' +
                '<td>' + nombreProducto + '</td>' +
                '<td>' + descripcionProducto + '</td>' +
                '<td>' + precioProducto.toFixed(2) + '</td>' +
                '<td>' + cantidadProducto + '</td>' +
                '<td>' + subtotal.toFixed(2) + '</td>' +
                '<td><button type="button" class="btn btn-danger btn-sm eliminarProducto">Eliminar</button></td>' +
                '</tr>'
            );

            actualizarTotal();

        } else {
            alert('Complete todos los campos antes de añadir el producto.');
        }
    });

    // Eliminar producto de la tabla
    $('#tablaProductos').on('click', '.eliminarProducto', function() {
        $(this).closest('tr').remove();
        actualizarTotal();
    });

    // Actualizar el total de la venta
    function actualizarTotal() {
        var total = 0;
        $('#tablaProductos tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('td:eq(5)').text());
            total += subtotal;
        });
        $('#totalVenta').val(total.toFixed(2));
    }

    // Enviar datos del formulario
    $('#ventaForm').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío por defecto del formulario
    
        var productos = [];
        $('#tablaProductos tbody tr').each(function() {
            var fila = $(this);
            productos.push({
                id_producto: fila.find('.id-producto').text(),
                codigo_producto: fila.find('td:eq(0)').text(), // Asegúrate de que estos valores están disponibles
                cantidad: parseInt(fila.find('td:eq(4)').text()),
                precio_unitario: parseFloat(fila.find('td:eq(3)').text()),
                subtotal: parseFloat(fila.find('td:eq(5)').text())
            });
        });

        // Añadir console logs para depuración
        console.log("ID Cliente:", $('#idCliente').val());
        console.log("Estado de Pago:", $('#estadoPago').val());
        console.log("Total Venta:", $('#totalVenta').val());
        console.log("Productos:", productos);
    
        $.ajax({
            url: '../scriptsphp/procesar_venta.php',
            method: 'POST',
            data: {
                id_cliente: $('#idCliente').val(),
                estado_pago: $('#estadoPago').val(),
                totalVenta: $('#totalVenta').val(),
                productos: JSON.stringify(productos) // Enviar los productos como JSON
            },
            success: function(response) {
                alert(response);
                // Opcional: Redirigir a otra página o limpiar el formulario
            },
            error: function(xhr, status, error) {
                console.error('Error al procesar la venta:', error);
            }
        });
    });
});
