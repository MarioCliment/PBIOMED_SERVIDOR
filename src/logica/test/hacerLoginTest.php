<?php
use PHPUnit\Framework\TestCase;

require_once('../logica/hacerLogin.php'); // Importa la función autenticarUsuario

class hacerLoginTest extends TestCase
{
    public function testAutenticarUsuarioConCredencialesCorrectas()
    {
        // Parámetros de ejemplo
        $user = "mario.climent";
        $password = "1234";

        // Llama a la función autenticarUsuario
        $resultado = autenticarUsuario($user, $password);

        // Verifica que la función haya tenido éxito
        $this->assertTrue($resultado);
    }

    public function testAutenticarUsuarioConCredencialesIncorrectas()
    {
        // Parámetros de ejemplo con credenciales incorrectas
        $user = "usuario_inexistente";
        $password = "contrasena_incorrecta";

        // Llama a la función autenticarUsuario
        $resultado = autenticarUsuario($user, $password);

        // Verifica que la función haya fallado
        $this->assertFalse($resultado);
    }
}
