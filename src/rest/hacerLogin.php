<?php

require_once('../logica/hacerLogin.php');

// ----------------------------------------------------------------
//
// POST ../rest/hacerLogin.php
//
// @params
// - user:Texto
// - password:Texto
//
// @return
//  VoF: true si el login es exitoso
// 
// @return
//  usuario:Texto
//       devuelto implícitamente en la variable global de sesión
//       (en el navegador no se podrá acceder a la var. global)
//
// ----------------------------------------------------------------

$objetoResultado = new stdClass;

// Iniciar una sesión
session_start();

// Obtener valores de los parámetros GET
$user = isset($_GET["user"]) ? $_GET["user"] : "";
$password = isset($_GET["password"]) ? $_GET["password"] : "";

// Llamada a la función de verificación de login
if (autenticarUsuario($user, $password) == true) {

    // Establecer la sesión de usuario
    $_SESSION["user"] = $user;

    $objetoResultado->resultado = true;
    $objetoResultado->usuario = $user;

} else {
    session_destroy();
    $objetoResultado->resultado = false;
}

// Devolver una respuesta JSON
header("Content-Type: application/json");
echo json_encode($objetoResultado);
?>