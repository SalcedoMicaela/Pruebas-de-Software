<?php
$action = $_POST['action'];
$crud = new Crud();

if ($action == 'create') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];
    
    $data = $crud->create($nombres, $apellidos, $cedula, $email, $username, $password, $telefono, $direccion, $rol);
    echo $data;
}elseif ($action == 'read') {
    $data = $crud->read();
    echo $data;
}elseif ($action == 'edit') {
    $id = $_POST['id'];
    $data = $crud->edit($id);
    echo $data;
}elseif ($action == 'desactive') {
    $id_usuario = $_POST['id_usuario'];
    $data = $crud->desactive($id_usuario);
    echo $data;
}elseif($action == 'active'){
    $id_usuario = $_POST['id_usuario'];
    $data = $crud->active($id_usuario);
    echo $data;
}elseif ($action == 'update') {
    $id_p = $_POST['id_p'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $data = $crud->update($id_p,$name,$lastname,$email,$age,$birthday);
    echo $data;
}elseif($action == 'loadRols'){
    $data = $crud->loadRols();
    echo $data;
}elseif($action == 'createRol'){
    $nombre_rol = $_POST['nombre_rol'];
    $descripcion = $_POST['descripcion'];
    $accesos = $_POST['accesos'];
    $data = $crud->createRol($nombre_rol, $descripcion, $accesos);
    echo $data;
}

class Crud {
    public $conn = null;

    public function __construct() {
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'admin';
        $pass = getenv('DB_PASS') ?: 'admin';
        $dbname = getenv('DB_NAME') ?: 'sistema_inventario';

        $this->conn = new mysqli($host, $user, $pass, $dbname);

        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function create($nombres, $apellidos, $cedula, $email, $username, $password, $telefono, $direccion, $rol) {
        $encryptedPassword = $this->encryptPassword($password);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, email, username, password, telefono, direccion, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nombres, $apellidos, $cedula, $email, $username, $encryptedPassword, $telefono, $direccion, $rol);

        $response = [];
        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'User registered successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Execution failed: ' . $stmt->error];
        }
        
        $stmt->close();
        return json_encode($response);
    }

    private function encryptPassword($password) {
        $passphrase = 'Password';
        return openssl_encrypt(
            $password,
            'aes-256-cbc',
            $passphrase,
            0,
            substr(hash('sha256', $passphrase, true), 0, 16)
        );
    }

    public function createRol($nombre_rol, $descripcion, $accesos) {
        $stmt = $this->conn->prepare("INSERT INTO roles (nombre_rol, descripcion, accesos) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre_rol, $descripcion, $accesos);

        $response = [];
        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Rol registered successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Execution failed: ' . $stmt->error];
        }
        
        $stmt->close();
        return json_encode($response);
    }

    public function loadRols() {
        $con = $this->conn->query("SELECT id_rol, nombre_rol FROM roles");
        $roles = [];

        if ($con->num_rows > 0) {
            while ($row = $con->fetch_assoc()) {
                $roles[] = $row;
            }
        }
        echo json_encode($roles);
    }

    public function read() {
        $table = "";
        $res = $this->conn->query("SELECT u.id_usuario, u.nombre, u.apellido, u.cedula, u.email, u.username, u.telefono, r.nombre_rol AS rol, r.accesos, u.estado FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol");
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_array()) {
                $table .= "<tr>";
                $table .= "<td>".$row['id_usuario']."</td>";
                $table .= "<td>".$row['nombre']."</td>";
                $table .= "<td>".$row['apellido']."</td>";
                $table .= "<td>".$row['cedula']."</td>";
                $table .= "<td>".$row['email']."</td>";
                $table .= "<td>".$row['username']."</td>";
                $table .= "<td>".$row['telefono']."</td>";
                $table .= "<td>".$row['rol']."</td>";
                $table .= "<td>".$row['accesos']."</td>";
                $table .= "<td>".$row['estado']."</td>";
                $table .= "<td><button type='button' class='btn btn-primary' onclick='editarUsuario(".$row['id_usuario'].")'>Editar</button>";
                if($row['estado'] == 'activo'){
                    $table .="<button type='button' class='btn btn-danger' onclick='desactivarUsuario(".$row['id_usuario'].")'>Desactivar</button></td>";
                } else {
                    $table .="<button type='button' class='btn btn-success' onclick='activarUsuario(".$row['id_usuario'].")'>Activar</button></td>";
                }
                $table .= "</tr>";
            }
            $table .= "</table>";
            return $table;
        } else {
            $table .= "</table>";
            return $table;
        }
    }

    public function edit($id) {
        $jsondata = [];
        $res = $this->conn->query("SELECT * FROM persona WHERE id=".$id);

        while ($row = $res->fetch_array()) {
            $jsondata[] = [
                'id' => $row['id'],
                'name' => $row['nombre'],
                'lastname' => $row['apellido'],
                'email' => $row['email'],
                'age' => $row['edad'],
                'birthday' => $row['fnac']
            ];
        }

        header('Content-type: application/json; charset=utf-8');
        return json_encode($jsondata);
    }

    public function desactive($id_usuario) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET estado = 'desactivo' WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        
        if ($stmt->execute()) {
            $stmt->close(); // Close statement after execution if needed
            return json_encode(['status' => 'success', 'message' => 'User deactivated successfully.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Execution failed: ' . $stmt->error]);
        }
        
        $stmt->close();
    }

    public function active($id_usuario) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET estado = 'activo' WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        
        if ($stmt->execute()) {
            $stmt->close(); // Close the statement before returning
            return json_encode(['status' => 'success', 'message' => 'User activated successfully.']);
        } else {
            $stmt->close(); // Close the statement before returning
            return json_encode(['status' => 'error', 'message' => 'Execution failed: ' . $stmt->error]);
        }
        
        $stmt->close();
    }

    public function update($id, $name, $lastname, $email, $age, $birthday) {
        $stmt = $this->conn->prepare("UPDATE persona SET nombre = ?, apellido = ?, email = ?, edad = ?, fnac = ? WHERE id = ?");
        $stmt->bind_param("sssisi", $name, $lastname, $email, $age, $birthday, $id);
        
        if ($stmt->execute()) {
            $stmt->close(); // Close the statement before returning
            return json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
        } else {
            $stmt->close(); // Close the statement before returning
            return json_encode(['status' => 'error', 'message' => 'Execution failed: ' . $stmt->error]);
        }
        
        $stmt->close();
    }
}
?>
