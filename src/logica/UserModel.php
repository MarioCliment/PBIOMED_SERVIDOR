<?php
require_once "Database.php";
require_once "MeasureModel.php";

class UserModel extends Database
{
    private $objetoResultado;

    //Funcion para obtener todos los usuarios
    //-----------------------------------------------------------------------
    // int -> getAllusers() -> array{usuarios}
    //-----------------------------------------------------------------------
    public function getAllUsers($limit)
    {
        return $this->select("SELECT * FROM usuario ORDER BY email ASC LIMIT ?", ["i", $limit]);
    }

    //Funcion para obtener un usuario
    //-----------------------------------------------------------------------
    // string -> getThisUser() -> usuario
    //-----------------------------------------------------------------------
    public function getThisUser($nickname)
    {
        return $this->select("SELECT * FROM usuario WHERE nickname = '$nickname'");
    }

    //Funcion para añadir un usuario
    //-----------------------------------------------------------------------
    // string, string, string, string -> addUser() -> ToF
    //-----------------------------------------------------------------------
    public function addUser($email, $contrasenya, $nombreApellidos, $nickname, $confirmado, $codigo){
        return $this->insert("INSERT INTO usuario (email, contrasenya, rol, nombreApellidos, nickname, confirmado, codigo) VALUES ('$email', '$contrasenya', 'usuario', '$nombreApellidos', '$nickname', '$confirmado', '$codigo')");
    }

    //Funcion para verificar el login un usuario
    //-----------------------------------------------------------------------
    // string, string -> loginUser() -> ToF
    //-----------------------------------------------------------------------
    public function loginUser($nickname, $contrasenya) {
        $result =  $this->selectFetch("SELECT * FROM usuario WHERE nickname = '$nickname' AND contrasenya = '$contrasenya'");

        if ($result != null){
            return true;
        }

        return false;
    }

    //Funcion para cerrar la sesion
    //-----------------------------------------------------------------------
    //  -> logoutUser() -> T
    //-----------------------------------------------------------------------
    public function logoutUser() {
        return true;
    }

    //Funcion para verificar el login un usuario
    //-----------------------------------------------------------------------
    // string, string, string, string -> updateThisUser() -> ToF
    //-----------------------------------------------------------------------
    public function updateThisUser($email, $nombreApellidos, $nickname, $originalNickname){
        $result =  $this->update("UPDATE usuario SET email = '$email',nombreApellidos = '$nombreApellidos', nickname = '$nickname' WHERE nickname = '$originalNickname'");

        if ($result == true){
            return $this->getThisUser($nickname);
        }

        return false;
    }

    //Funcion para verificar el login un usuario
    //-----------------------------------------------------------------------
    // string, string -> addMeasureUser() -> ToF
    //-----------------------------------------------------------------------
    public function addMeasureUser($nickname, $idTipoMedicion, $fecha, $lugar, $valor){
        $measureModel = new MeasureModel();
        $result = $measureModel->addMeasure($idTipoMedicion, $fecha, $lugar, $valor);
        if ($result == true){
            $userData = $this->getThisUser($nickname);
            $email = $this->returnEmail($userData);
            $medicionData = $measureModel->getLastMeasure();
            $idMedicion = $medicionData[0]["idMedicion"];

            $response = $this->relateUserAndMeasure($email,$idMedicion);
            return $response; 
        }
        return false;
    }

    //Funcion para verificar el login un usuario
    //-----------------------------------------------------------------------
    // string, string -> relateUserAndMeasure() -> ToF
    //-----------------------------------------------------------------------
    private function relateUserAndMeasure($email,$idMedicion){
        return $this->insert("INSERT INTO `usuario-medicion` (email, idMedicion) VALUES ('$email', '$idMedicion')");
    }    

    //Funcion para verificar el login un usuario
    //-----------------------------------------------------------------------
    // string, string -> getAllUserMeasures() -> array{mediciones}
    //-----------------------------------------------------------------------
    public function getAllUserMeasures($nickname, $limit){
        $userData = $this->getThisUser($nickname);
        $email = $this->returnEmail($userData);

        return $this->select("SELECT mediciones.* FROM `usuario-medicion` JOIN mediciones
        ON `usuario-medicion`.idMedicion = mediciones.idMedicion WHERE `usuario-medicion`.email = '$email' ORDER BY `mediciones`.idMedicion DESC LIMIT ?", ["i", $limit]);

    }

    //Funcion para devolver el email del usuario
    //-----------------------------------------------------------------------
    // objetoUsuario -> returnEmail() -> string
    //-----------------------------------------------------------------------
    private function returnEmail($userData){
        return $userData[0]["email"];
    }

    public function sendEmail($email){
        // Varios destinatarios
        $para  = $email . ', '; // atención a la coma
        //$para .= 'example@example.com';

        // título
        $título = 'Gracias por registrarte';

        //aleatoria
        $codigo = rand(1000,9999);

        //CAMBIAR IP PARA USOS
        $ipserver = "192.168.1.148:80"; //CASA GRASA
        // mensaje
        $mensaje = '
        <html>
        <head>
            <meta charset="UTF8" />
        <title>Recordatorio de cumpleaños para Agosto</title>
        </head>
        <body>
        <p>TU CÓDIGO DE VERIFICACIÓN ES : </p>
        <h2>'.$codigo.'</h2>
        <p> 
            <a 
            href="http://'.$ipserver.'/PBIOMED_SERVIDOR/src/ux/verification/confirmation.php?email='.$email.'">
            VERIFICA TU CUENTA </a> 
        </p>
        
        
        </body>
        </html>
        ';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: ozonewardencontact@gmail.com' . "\r\n";
        /*
        // Cabeceras adicionales
        $cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
        $cabeceras .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
        $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        $cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";*/

        $this->objetoResultado = new stdClass;

        // Enviarlo
        $this->objetoResultado->enviado=false;
        if(mail($para, $título, $mensaje, $cabeceras)){
            $this->objetoResultado->enviado=true;
        }
        $this->objetoResultado->codigo=$codigo;

        return $this->objetoResultado;
    }

    //-----------------------------------------------------------------------
    // string, double -> verifyThisUser() -> ToF
    //-----------------------------------------------------------------------
    public function verifyThisUser($email, $codigo){
        $result =  $this->update("UPDATE usuario SET confirmado = 'si' WHERE email = '$email' AND codigo='$codigo'");

        if ($result == true){
            return true;
        }

        return false;
    }

}
?>