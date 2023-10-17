<?php
use PHPUnit\Framework\TestCase;

require_once('../logica/Database.php');
require_once('../logica/hacerLogout.php'); // Importa la función hacerLogout
require_once('../logica/hacerLogin.php'); // Importa la función hacerLogin

class HacerLogoutTest extends TestCase
{
    public function testCerrarSesion() {
        /*// Iniciar la sesión (debes estar seguro de que se ha iniciado antes de cerrarla)
        session_start();*/

        // Iniciar una sesión
        session_start();
        
        $user = "mario.climent";
        $password = "1234";

        // Llama a la función autenticarUsuario y si exsite lo guarda en la sesion
        if (autenticarUsuario($user, $password) == true) {

            // Establecer la sesión de usuario
            $_SESSION["user"] = $user;
        
        }

        // Realizar una aserción para comprobar si la sesión está activa
        $this->assertArrayHasKey('user', $_SESSION);
    
        hacerLogout();

        // Realizar una aserción para comprobar que 'user' no está presente en la sesión
        $this->assertArrayNotHasKey('user', $_SESSION);
    }

    public function testRedireccionCorrecta() {
        // Iniciar el almacenamiento del búfer de salida y habilitar la función de redirección
        ob_start();
    
        hacerLogout();
        
        // Obtener el contenido del búfer de salida
        $output = ob_get_clean();
        
        // Realizar una aserción para verificar si se produce la redirección
        $this->assertStringContainsString("Location: ../ux/Aplicacion.html", $output);
    }

}

