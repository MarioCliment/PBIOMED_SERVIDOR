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
    public function addUser($email, $contrasenya, $nombreApellidos, $nickname){
        return $this->insert("INSERT INTO usuario (email, contrasenya, rol, nombreApellidos, nickname) VALUES ('$email', '$contrasenya', 'usuario', '$nombreApellidos', '$nickname')");
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

}
?>