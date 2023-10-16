<?php
require_once('../logica/Database.php'); // Importa la clase Database

// Crear una instancia de la clase Database
$db = new Database();

// Obtener una conexión a la base de datos
$conexion = $db->getConnection();

// Incluye la lógica para obtener mediciones
require_once('../logica/recuperarMediciones.php');

// Manejar la API REST para obtener mediciones
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener mediciones y responder con JSON
    header("Content-Type: application/json");
    echo json_encode(recuperarMediciones($conexion));
}
