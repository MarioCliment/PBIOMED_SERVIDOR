<?php
/*echo "Script index.php alcanzado.";
exit;*/
require "../inc/bootstrap.php";

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', $requestUri);

// Verificar el recurso solicitado y el método correspondiente
$requestedResource = isset($uriSegments[4]) ? $uriSegments[4] : '';

switch ($requestedResource) {
    case 'user':
        require "controller/api/UserController.php";
        $userController = new UserController();
        $action = isset($uriSegments[5]) ? $uriSegments[5] : '';
        switch ($action) {
            case 'all':
                $userController->getAllUsers();
                break;
            case 'add':
                $userController->addUser();
                break;
            case 'login':
                $userController->loginUser();
                break;
            case 'logout':
                $userController->logoutUser();
                break;
            case 'data':
                $userController->getThisUser();
                break;
            case 'edit':
                $userController->updateThisUser();
                break;
            case 'password':
                $userController->updatePassword();
                break;
            case 'sendEmail':
                $userController->sendEmail();
                break;
            case 'verify':
                $userController->verifyThisUser();
                break;
            case 'nodes':
                $userController->getAllUserDetails();
                break;
            case 'probe':
                $probeAction = isset($uriSegments[6]) ? $uriSegments[6] : '';
                switch ($probeAction) {
                    case 'all':
                        $allProbeAction = isset($uriSegments[7]) ? $uriSegments[7] : '';
                        switch ($allProbeAction) {
                            case 'state':
                                $userController->allProbesStateAction();
                                break;
                            default:
                                $userController->allProbesAction();
                        }
                        break;
                    case 'state':
                        $userController->probeStateAction();
                        break;
                    // Agrega más casos según sea necesario
                    default:
                        sendNotFoundResponse();
                }
                break;
            case 'measure':
                $measureAction = isset($uriSegments[6]) ? $uriSegments[6] : '';
                switch ($measureAction) {
                    case 'add':
                        $userController->addMeasureUser();
                        break;
                    case 'all':
                        $allMeasureAction = isset($uriSegments[7]) ? $uriSegments[7] : '';
                        switch ($allMeasureAction) {
                            case 'data':
                                $userController->getAllUserMeasures();
                                break;
                            case 'place':
                                $userController->measureAllPlaceAction();
                                break;
                            case 'time':
                                $userController->measureAllTimeAction();
                                break;
                            // Agrega más casos según sea necesario
                            default:
                                $userController->measureAllAction();
                        }
                        break;
                    case 'median':
                        $medianMeasureAction = isset($uriSegments[5]) ? $uriSegments[5] : '';
                        switch ($medianMeasureAction) {
                            case 'place':
                                $userController->measureMedianPlaceAction();
                                break;
                            case 'num':
                                $userController->measureMedianNumAction();
                                break;
                            case 'time':
                                $userController->measureMedianTimeAction();
                                break;
                            // Agrega más casos según sea necesario
                            default:
                                $userController->measureMedianAction();
                        }
                        break;
                    // Agrega más casos según sea necesario
                    default:
                        sendNotFoundResponse();
                }
                break;
            // Agrega más casos según sea necesario
            default:
                sendNotFoundResponse();
        }
        break;
    case 'measure':
        require "controller/api/MeasureController.php";
        $measureController = new MeasureController;
        $measureAction = isset($uriSegments[5]) ? $uriSegments[5] : '';

        switch ($measureAction) {
                case 'all':
                    $allMeasureAction = isset($uriSegments[6]) ? $uriSegments[6] : '';
                    switch ($allMeasureAction) {
                        case 'data':
                            $measureController->getAllMeasures()();
                            break;
                        case 'place':
                            $measureController->measureMedianPlaceAction();
                            break;
                        case 'time':
                            $measureController->measureMedianPlaceAction();
                            break; 
                    }
                    
                    break;
                case 'median':
                    $medianMeasureAction = isset($uriSegments[4]) ? $uriSegments[4] : '';
                    switch ($medianMeasureAction) {
                        case 'place':
                            $userController->measureMedianPlaceAction();
                            break;
                        case 'num':
                            $userController->measureMedianNumAction();
                            break;
                        case 'time':
                            $userController->measureMedianTimeAction();
                            break;
                        // Agrega más casos según sea necesario
                        default:
                            $userController->measureMedianAction();
                    }
                    break;   
                // Agrega más casos según sea necesario
                default:
                    sendNotFoundResponse();
        }// Agrega más casos según sea necesario
        break;
    // Agrega más recursos según sea necesario
    default:
        sendNotFoundResponse();
}

function sendNotFoundResponse() {
    header("HTTP/1.1 404 Not Found");
    exit();
}

?>