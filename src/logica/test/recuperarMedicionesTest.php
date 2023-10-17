<?php
use PHPUnit\Framework\TestCase;

require_once('../logica/Database.php');
require_once('../logica/recuperarMediciones.php');

class recuperarMedicionesTest extends TestCase
{
    public function testRecuperarMediciones()
    {
        // Simula una sesión con un usuario
        session_start();
        $_SESSION["user"] = "usuario_de_prueba";

        // Crea una instancia de la clase Database
        $db = new Database();

        // Obtiene una conexión a la base de datos
        $conexion = $db->getConnection();

        // Ejecuta la función que deseas probar
        $result = recuperarMediciones($conexion);

        // Verifica que la función devuelva un array
        $this->assertIsArray($result);

        // Puedes realizar más aserciones según lo que esperes de la función
        // Por ejemplo, puedes verificar que el resultado contenga ciertos elementos

        // Cierra la sesión
        session_destroy();
    }
}

