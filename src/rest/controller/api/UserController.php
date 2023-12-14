<?php
require_once "BaseController.php";

class UserController extends BaseController
{
    /** 
* "/user/list" Endpoint - Get list of users 
*/
    private $objetoResultado;

    public function getAllUsers()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
          
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];  
                }

                $arrUsers = $userModel->getAllUsers($intLimit);
                $responseData = json_encode($arrUsers);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function getThisUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $nickname = 10;
                if (isset($arrQueryStringParams['nickname']) && $arrQueryStringParams['nickname']) {
                    $nickname = $arrQueryStringParams['nickname'];  
                }
                $user = $userModel->getThisUser($nickname);
                $responseData = json_encode($user);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function addUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $data = json_decode(file_get_contents('php://input'));

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel();
                $this->objetoResultado = new stdClass;

                $email = $data->email;
                $contrasenya = $data->contrasenya;  
                $nombreApellidos = $data->nombreApellidos;  
                $nickname = $data->nickname; 

                $user = $userModel->addUser($email, $contrasenya, $nombreApellidos, $nickname);
                $this->objetoResultado->resultado = $user;
                $responseData = json_encode($this->objetoResultado);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function loginUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $this->objetoResultado = new stdClass;

                if (isset($arrQueryStringParams['nickname']) && $arrQueryStringParams['nickname']) {
                    $nickname = $arrQueryStringParams['nickname'];  
                }
                if (isset($arrQueryStringParams['contrasenya']) && $arrQueryStringParams['contrasenya']) {
                    $contrasenya = $arrQueryStringParams['contrasenya'];  
                }
                $loginResponse = $userModel->loginUser($nickname,$contrasenya);


                if ($loginResponse == true) {
                    // Iniciar una sesión
                    session_start();
                    // Establecer la sesión de usuario
                    $_SESSION["user"] = $nickname;
                
                    $this->objetoResultado->resultado = true;
                    $this->objetoResultado->nickname = $nickname;
                
                } else {
                    $this->objetoResultado->resultado = false;
                }                


                $responseData = json_encode($this->objetoResultado);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function logoutUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'DELETE') {
            try {
                $userModel = new UserModel();
                $this->objetoResultado = new stdClass;

                $logoutResponse = $userModel->logoutUser();


                if ($logoutResponse == true) {
                    session_start();
                    //Obtengo el usuario de la sesión
                    $nickname  = $_SESSION["user"];
                    
                    // Cierro la sesión
                    session_destroy();
                    
                    $this->objetoResultado->resultado = true;
                    $this->objetoResultado->nickname = $nickname;
                    $this->objetoResultado->happened = "Session destroyed";
                
                } else {
                    $this->objetoResultado->resultado = false;
                }                


                $responseData = json_encode($this->objetoResultado);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    //Añadir lo de la contraseña

    public function updateThisUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $data = json_decode(file_get_contents('php://input'));
        if (strtoupper($requestMethod) == 'PUT') {
            try {
                
                $userModel = new UserModel();
                $this->objetoResultado = new stdClass;

                $email = $data->email;
                $nombreApellidos = $data->nombreApellidos;  
                $nickname = $data->nickname; 
                $oldNickname = $data->oldNickname;

                $response = $userModel->updateThisUser($email, $nombreApellidos, $nickname, $oldNickname);
                
                $responseData = json_encode($response);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

            
        
        
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function addMeasureUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $data = json_decode(file_get_contents('php://input'));

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel();
                $this->objetoResultado = new stdClass;
 
                $nickname = $data->nickname;
                $idTipoMedicion = $data->idTipoMedicion; 
                $fecha = $data->fecha;
                $lugar = $data->lugar;
                $valor = $data->valor;

                $result = $userModel->addMeasureUser($nickname, $idTipoMedicion, $fecha, $lugar, $valor);

                $this->objetoResultado->resultado = $result;
                $responseData = json_encode($this->objetoResultado);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function getAllUserMeasures()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
          
        if (strtoupper($requestMethod) == 'GET') {
            try {
                session_start();
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];  
                }
                if (isset($arrQueryStringParams['nickname']) && $arrQueryStringParams['nickname']) {
                    $nickname = $arrQueryStringParams['nickname'];  
                }
                else{
                    $nickname = $_SESSION['user'];
                }

                $arrMeasures = $userModel->getAllUserMeasures($nickname, $intLimit);
                $responseData = json_encode($arrMeasures);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function sendEmail(){
        $userModel = new UserModel();
        $userModel->sendEmail();
    }


}