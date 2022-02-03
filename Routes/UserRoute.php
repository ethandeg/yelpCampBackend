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
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch(true){
            case ($path === '/' && strtoupper($requestMethod) === 'GET'):
                $userCon->listAction();
                break;
            case ($path === "/" && strtoupper($requestMethod) === 'POST'):
                $userCon->createAction();
                break;
            default:
                echo "hit default";
                echo $path . " " . $requestMethod;
        }
    }
}
?>
