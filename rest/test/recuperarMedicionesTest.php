<?php
use PHPUnit\Framework\TestCase;

class RecuperarMedicionesTest extends TestCase
{
    public function testObtenerMediciones()
    {
        session_start();
        $_SESSION["user"] = "mario.climent";
        $_SESSION["id_usuario"] = 1;

        // Simula una solicitud GET al script recuperarMediciones.php
        $url = 'http://localhost/tu_proyecto/rest/recuperarMediciones.php';
        $response = file_get_contents($url);

        // Verifica que la respuesta sea válida (un JSON válido)
        $this->assertNotFalse($response, 'No se pudo obtener la respuesta');
        $data = json_decode($response, true);
        $this->assertNotFalse($data, 'La respuesta no es un JSON válido');

        // Verifica el formato esperado del JSON de respuesta
        $this->assertArrayHasKey('mediciones', $data);
        $this->assertIsArray($data['mediciones']);
        // Agrega más aserciones según el formato de las mediciones

        // También puedes verificar que la respuesta tenga el código de estado HTTP 200
        $headers = get_headers($url, 1);
        $this->assertArrayHasKey('HTTP/1.1 200', $headers);
    }
}
