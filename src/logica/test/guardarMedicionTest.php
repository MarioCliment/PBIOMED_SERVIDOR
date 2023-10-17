<?php

use PHPUnit\Framework\TestCase;

require_once('../logica/Database.php');
require_once('../logica/guardarMedicion.php');

class GuardarMedicionTest extends TestCase
{
    public function testGuardarMedicion()
    {
        // Simula una sesión con un usuario
        session_start();
        $_SESSION["usuario"] = "usuario_de_prueba";
        $_SESSION["id_usuario"] = 1; // ID de usuario de prueba

         // Los datos que deseas probar
        $tiempo = '12:00:00';
        $temperatura = 25.5;
        $concentracion = 0.1;

        // Llamar a la función que deseas probar
        $resultado = guardarMedicion($tiempo, $temperatura, $concentracion);

        // Asegúrate de que el resultado sea un array
        $this->assertIsArray($resultado);

        // Asegúrate de que no haya errores
        $this->assertArrayNotHasKey('error', $resultado);

        // Cierra la sesión
        session_destroy();
    }
}

