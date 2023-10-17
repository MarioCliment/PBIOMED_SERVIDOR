<?php
require_once('Database.php'); // Importa la clase Database

// Iniciar una sesión
session_start();

function guardarMedicion($tiempo, $temperatura, $concentracion) {
    // Crear una instancia de la clase Database
    $db = new Database();

    // Obtener una conexión a la base de datos
    $conexion = $db->getConnection();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["usuario"])) {
        return ["error" => "El usuario no ha iniciado sesión"];
    }

    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION["id_usuario"];

    // Ejecutar la sentencia
    if ($conexion->query("INSERT INTO mediciones (id_usuario, tiempo, temperatura, concentracion) VALUES ($id_usuario, '$tiempo', $temperatura, $concentracion)")) {
        return ["success" => "Medición guardada con éxito"];
    } else {
        return ["error" => "Error al guardar la medición: " . $conexion->error];
    }

    // Cerrar la conexión a la base de datos
    $db->closeConnection();
}

?>
