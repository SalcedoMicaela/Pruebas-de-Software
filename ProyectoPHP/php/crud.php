<?php
// Obtenemos las credenciales desde variables de entorno (no hardcodeadas)
$servidor = "mysql:dbname=sistema_inventario;host=localhost";
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");

try {
    $pdo = new PDO($servidor, $user, $pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}





