<?php
require_once "Database.php";
require_once "MeasureModel.php";

class UserModel extends Database
{
    private $objetoResultado;

    public function getAllUsers($limit)
    {
        return $this->select("SELECT * FROM usuario ORDER BY email ASC LIMIT ?", ["i", $limit]);
    }

    public function getThisUser($nickname)
    {
        return $this->select("SELECT * FROM usuario WHERE nickname = '$nickname'");
    }

    public function addUser($email, $contrasenya, $nombreApellidos, $nickname){
        return $this->insert("INSERT INTO usuario (email, contrasenya, rol, nombreApellidos, nickname) VALUES ('$email', '$contrasenya', 'usuario', '$nombreApellidos', '$nickname')");
    }

    public function loginUser($nickname, $contrasenya) {
        $result =  $this->selectFetch("SELECT * FROM usuario WHERE nickname = '$nickname' AND contrasenya = '$contrasenya'");

        if ($result != null){
            return true;
        }

        return false;
    }

    public function logoutUser() {
        return true;
    }

    public function updateThisUser($email, $nombreApellidos, $nickname, $originalNickname){
        $result =  $this->update("UPDATE usuario SET email = '$email',nombreApellidos = '$nombreApellidos', nickname = '$nickname' WHERE nickname = '$originalNickname'");

        if ($result == true){
            return $this->getThisUser($nickname);
        }

        return false;
    }

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

    private function relateUserAndMeasure($email,$idMedicion){
        return $this->insert("INSERT INTO `usuario-medicion` (email, idMedicion) VALUES ('$email', '$idMedicion')");
    }    

    public function getAllUserMeasures($nickname, $limit){
        $userData = $this->getThisUser($nickname);
        $email = $this->returnEmail($userData);

        return $this->select("SELECT mediciones.* FROM `usuario-medicion` JOIN mediciones
        ON `usuario-medicion`.idMedicion = mediciones.idMedicion WHERE `usuario-medicion`.email = '$email' ORDER BY `mediciones`.idMedicion DESC LIMIT ?", ["i", $limit]);

    }

    private function returnEmail($userData){
        return $userData[0]["email"];
    }

}