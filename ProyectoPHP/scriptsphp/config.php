<?php
    // Usa variables de entorno para mayor seguridad
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_user = getenv('DB_USER') ?: 'root';
    $db_pass = getenv('DB_PASS') ?: '';
    $db_name = getenv('DB_NAME') ?: 'basefinal';

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_errno()) {
        echo "Fallo en la base de datos: " . mysqli_connect_error();
        exit();
    }
?>
