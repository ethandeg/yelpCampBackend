<?php
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";
require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";
require_once PROJECT_ROOT_PATH . "/inc/authenticate.php";
class UserController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction(){
        //put error handling stuff as a next function that is called, that gives error info if error, to clean up the functions
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

                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
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
    /**
     * "/user "Create a User"
     */
    public function createAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) === 'POST'){
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                $newUser = new UserModel();
                $hash_password = password_hash($data['password'], PASSWORD_DEFAULT);
                $data['password'] = $hash_password;
                $newUser->createUser($data);
                $username = $data['username'];
                $user = $newUser->getUser('username', $username);
                $userId = $user[0]['user_id'];
                $token = createToken(['username' => $data['username'], 'userId' => $userId]);
                $responseData = json_encode(["msg" => "success", "_token" => $token]);
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
     * Get a specific user based on ['username' =>] or ['user_id' =>]
     */
    public function searchUser($identifier, $value){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) === "GET"){
            try {
                $userMod = new UserModel();
                $user = $userMod->getUser($identifier, $value);
                $responseData = json_encode($user[0]);
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

    public function login($userData){
        $strErrorDesc = '';
        try {
            $userMod = new UserModel();
            $user = $userMod->authenticateUser($userData);
            $token = createToken(['username' => $user['username'], 'userId' => $user['user_id']]);
            $responseData = json_encode(['success' => true, '_token' => $token]);
        } catch(Error $e){
            $strErrorDesc = $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 401 Internal Server Error';
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