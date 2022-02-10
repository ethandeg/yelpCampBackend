<?php
require_once PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require_once PROJECT_ROOT_PATH . "/Routes/BaseRoute.php";
class UserRoute extends BaseRoute {
    /**
     * Calls the appropriate controller method based on route and request method
     * 
     * @return void
     */
    public function callFunc(){
        $userCon = new UserController();
        $path = $this->getPath('user');
        $pathFrags = explode('/', $path);
        $pathLength = count($pathFrags);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch(true){
            case ($path === '/' && strtoupper($requestMethod) === 'GET'):
                $userCon->listAction();
                break;
            case ($path === "/" && strtoupper($requestMethod) === 'POST'):
                $userCon->createAction();
                break;
            case ($pathLength === 2 && $pathFrags[1] && strtoupper($requestMethod) === 'GET'):
                if(is_numeric($pathFrags[1])){
                    $userCon->searchUser('user_id', $pathFrags[1]);
                } else {
                    $userCon->searchUser('username', $pathFrags[1]);
                }
            case ($path === "/token"):
                $data = json_decode(file_get_contents('php://input'), true);
                $userCon->login($data);
                break;            
            default:
                echo "hit default";
                echo $path . " " . $requestMethod;
        }
    }
}
?>
