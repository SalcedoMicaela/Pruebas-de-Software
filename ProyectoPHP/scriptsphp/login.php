<?php
require_once('config.php');

$user = $_POST['username'];
$passwordLogin = $_POST['passwordLogin'];
$passphrase = 'Password'; 
$user = $conn->real_escape_string($user);
$stmt = $conn->prepare("SELECT u.id_usuario, u.username, u.passwordLogin, u.estado, r.nombre_rol, r.accesos as accesos 
                        FROM usuarios u 
                        LEFT JOIN roles r ON u.id_rol = r.id_rol 
                        WHERE u.username = ? AND u.estado = 'activo'");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $encryptedInputPassword = openssl_encrypt($passwordLogin, 'aes-256-cbc', $passphrase, 0, substr(hash('sha256', $passphrase, true), 0, 16));

    if ($encryptedInputPassword === $user_data['passwordLogin']) {
        session_start();
        $_SESSION['user'] = $user_data['username'];
        $_SESSION['accesos_usuario'] = $user_data['accesos'];

        echo json_encode(['success' => true, 'message' => 'Exito']);
    } else {
        // Contraseña no es válida
        echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrecto']);
    }
} else {
    // Usuario no encontrado
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrecto']);
}
?>
