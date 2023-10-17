<?php
require_once('../logica/guardarMedicion.php');

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $tiempo = $_POST["tiempo"];
    $temperatura = $_POST["temperatura"];
    $concentracion = $_POST["concentracion"];

    // Llamar a la función para guardar la medición
    $resultado = guardarMedicion($tiempo, $temperatura, $concentracion);

    // Devolver una respuesta JSON
    header("Content-Type: application/json");
    echo json_encode($resultado);
} else {
    // Método no permitido
    http_response_code(405); // Método no permitido
}
?>
