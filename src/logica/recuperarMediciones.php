<?php
require_once('../logica/Database.php'); // Importa la clase Database

// Iniciar una sesión
session_start();

// Crear una instancia de la clase Database
$db = new Database();

// Obtener una conexión a la base de datos
$conexion = $db->getConnection();

// Manejar la lógica para obtener las mediciones
function recuperarMediciones($conexion) {
    $user = $_SESSION["user"];

    // Realiza una consulta para obtener las mediciones del usuario
    $result = $conexion->query("select * from mediciones where id_usuario = (select id_usuario from usuarios where user = '$user')");

    $mediciones = [];

    while ($row = $result->fetch_assoc()) {
        $mediciones[] = $row;
    }

    return $mediciones;
}