<?php
require_once "BaseController.php";

class MeasureController extends BaseController
{
    private $objetoResultado;

    public function getAllMeasures()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
          
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $measureModel = new MeasureModel();

                $arrMeasures = $measureModel->getAllMeasures(1000);
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
}