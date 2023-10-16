<?php
require_once('../logica/Database.php'); // Importa la clase Database

// ---------------------------------------------------------------
//
// user:Texto, password:Texto -> autenticarUsuario() -> VoF
//
// ---------------------------------------------------------------

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
    $output = implode(',', $output);
    
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function autenticarUsuario($user, $password) {
    // Crear una instancia de la clase Database
    $db = new Database();

    // Obtener una conexión a la base de datos
    $conn = $db->getConnection();


    $sql = $conn->query("select * from usuarios where user = '$user' and password = '$password'");

    if ($sql->fetch_object()) {
        //Si existe el usuario
        return true; // Las credenciales son correctas
    }
   
    // Cerrar la conexión a la base de datos
    $db->closeConnection();

    return false; // Las credenciales son incorrectas
}


?>