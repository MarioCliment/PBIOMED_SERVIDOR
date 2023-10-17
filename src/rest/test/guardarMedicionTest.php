<?php
use PHPUnit\Framework\TestCase;

class GuardarMedicionTest extends TestCase
{
    public function testGuardarMedicion() 
    {
        session_start();
        $_SESSION["user"] = "usuario_de_prueba";
        $_SESSION["id_usuario"] = 1; // ID de usuario de prueba

        // Datos para enviar en la solicitud POST
        $data = [
            'tiempo' => '2023-10-15 12:00:00',
            'temperatura' => 25.5,
            'concentracion' => 0.1,
        ];

        // URL del servicio REST en guardarMedicion.php
        $url = 'http://localhost/prueba/rest/guardarMedicion.php';

        // Configurar las opciones de contexto para la solicitud POST
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);

        // Realizar la solicitud POST
        $response = file_get_contents($url, false, $context);

        // Analizar la respuesta JSON recibida
        $result = json_decode($response, true);

        // Realiza aserciones para verificar el resultado
        $this->assertArrayHasKey('success', $result);
        $this->assertEquals('Medición guardada con éxito', $result['success']);


    }
}