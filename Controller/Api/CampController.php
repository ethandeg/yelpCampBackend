<?php
require_once PROJECT_ROOT_PATH . "/Model/CampModel.php";
require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

class CampController extends BaseController
{
    /**
     * "/camp/list" Endpoint - Get list of camps
     */
    public function listAction(){
        //put error handling stuff as a next function that is called, that gives error info if error, to clean up the functions
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $campModel = new CampModel();

                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrcamps = $campModel->getCamps($intLimit);
                $responseData = json_encode($arrcamps);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
         else {
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

    public function createAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) === 'POST'){
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                $camp = new CampModel();
                $camp->createCamp($data);
                $responseData = json_encode(["msg" => "success"]);
            } catch(Error $e){
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }

        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if(!$strErrorDesc){
            $this->sendOutput($responseData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

     /**
     * @param array
     * Get a specific camp based on ['campname' =>] or ['camp_id' =>]
     */
    public function searchCampById($id){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) === "GET"){
            try {
                $campMod = new CampModel();
                $camp = $campMod->getCampById($id);
                $responseData = json_encode($camp[0]);
            } catch(Error $e){
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

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