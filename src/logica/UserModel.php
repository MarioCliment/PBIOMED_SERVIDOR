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

    //Funcion para obtener un usuario
    //-----------------------------------------------------------------------
    // string -> getThisUser() -> usuario
    //-----------------------------------------------------------------------
    public function getThisUserViaEmail($email)
    {
        return $this->select("SELECT * FROM usuario WHERE email = '$email'");
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

        $user = $this->select("SELECT * FROM usuario WHERE nickname = '$nickname'");

        $this->objetoResultado = new stdClass;

        $this->objetoResultado->rol = $user[0]["rol"];
        
        $response = false;

        if ($result != null && $user[0]["confirmado"] == "si"){
            $response = true;
        }

        $this->objetoResultado->response = $response;

        return  $this->objetoResultado;
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

    

    public function sendEmail($email, $nickname){

        // Varios destinatarios
        $para  = $email . ', '; // atención a la coma
        //$para .= 'example@example.com';

        // título
        $título = 'Verificación de usuario Ozone Warden. ¡Bienvenido '.$nickname.'!';

        //aleatoria
        $codigo = rand(1000,9999);

        //CAMBIAR IP PARA USOS
        $ipserver = "192.168.1.148:80"; //CASA GRASA
        //$ipserver = "192.168.10.7:80"; //MOVIL MAYRO
  

        // mensaje
        $mensaje = '
        <html>
        <head>
            <meta charset="UTF8" />
        <title>Codigo de verificación para tu cuenta</title>
        </head>
        <body>
        <p>Gracias por confiar en Ozone Warden. Para finalizar su registro y verficiar su cuenta, introduzca el siguiente código: </p>
        <h2>'.$codigo.'</h2>
        <p> 
            <a 
            href="http://'.$ipserver.'/PBIOMED_SERVIDOR/src/ux/verification/confirmation.php?email='.$email.'">
            VERIFICA TU CUENTA </a> 
        </p>
        <p>No compartas este código con nadie, Ozone Warden jamás te llamara o enviará un mensaje por teléfono solicitando el código </p>
        
        
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

    //Funcion para obtener los detalles de todos los usuarios
    //-----------------------------------------------------------------------
    // -> getAllUserDetails() -> array{stdClass}
    //-----------------------------------------------------------------------
    public function getAllUserDetails() {
        $users = $this->getAllUsers(1000);

        $allUserDetails = [];

        foreach ($users as $user) {
            $email = $user["email"];
            $nombreApellidos = $user["nombreApellidos"];

            // Obtener la última fecha de envío de datos
            $ultimaFechaEnvio = $this->getLastDataSendDate($email);

            $userDetails = new stdClass;
            $userDetails->email = $email;
            $userDetails->nombreApellidos = $nombreApellidos;
            $userDetails->ultimaFechaEnvio = $ultimaFechaEnvio;

            // Verificar que la fecha no sea null antes de agregar los detalles del usuario
            if ($ultimaFechaEnvio !== null) {
                $userDetails = new stdClass;
                $userDetails->email = $email;
                $userDetails->nombreApellidos = $nombreApellidos;
                $userDetails->ultimaFechaEnvio = $ultimaFechaEnvio;

                $allUserDetails[] = $userDetails;
            }

        }

        return $allUserDetails;
    }

    // Función para obtener la última fecha de envío de datos de un usuario
    private function getLastDataSendDate($email) {
        // Utiliza una única consulta para obtener la última fecha de envío de datos sin límite
        $result = $this->select("SELECT mediciones.fecha FROM `usuario-medicion`
                                    JOIN mediciones ON `usuario-medicion`.idMedicion = mediciones.idMedicion 
                                    WHERE `usuario-medicion`.email = '$email'
                                    AND `usuario-medicion`.idMedicion IS NOT NULL
                                    ORDER BY `mediciones`.idMedicion DESC
                                    LIMIT 1");

        if ($result !== null && !empty($result)) {
            // Accede a la fecha dentro del array asociativo
            $ultimaFechaEnvio = $result[0]['fecha'];
            return $ultimaFechaEnvio;
        } else {
            return null;
        }
    }
/*
    return $this->select("SELECT mediciones.* FROM `usuario-medicion` JOIN mediciones
        ON `usuario-medicion`.idMedicion = mediciones.idMedicion WHERE `usuario-medicion`.email = '$email' ORDER BY `mediciones`.idMedicion DESC LIMIT ?", ["i", $limit]);
*/


//Funcion para devolver el email del usuario
    //-----------------------------------------------------------------------
    // objetoUsuario -> returnEmail() -> string
    //-----------------------------------------------------------------------
    private function returnEmail($userData){
        return $userData[0]["email"];
    }

    //Funcion para devolver el nickname del usuario
    //-----------------------------------------------------------------------
    // objetoUsuario -> returnNickname() -> string
    //-----------------------------------------------------------------------
    private function returnNickname($userData){
        return $userData[0]["nickname"];
    }



}
?>