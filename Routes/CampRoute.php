<?php
require_once PROJECT_ROOT_PATH . "/Controller/Api/CampController.php";
require_once PROJECT_ROOT_PATH . "/Routes/BaseRoute.php";
class CampRoute extends BaseRoute {
    /**
     * Calls the appropriate controller method based on route and request method
     * 
     * @return void
     */
    public function callFunc(){
        $campCon = new CampController();
        $path = $this->getPath('camp');
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $pathFrags = explode('/', $path);
        $pathLength = count($pathFrags);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch(true){
            case ($path === '/' && strtoupper($requestMethod) === 'GET'):
                $campCon->listAction();
                break;
            case ($path === "/" && strtoupper($requestMethod) === 'POST'):
                $campCon->createAction();
                break;
            case ($pathLength === 2 && $pathFrags[1] && strtoupper($requestMethod) === "GET" && is_numeric($pathFrags[1])):
                $campCon->searchCampById((int)$pathFrags[1]);
                break;
            default:
                echo "hit default";
                echo $path . " " . $requestMethod;
        }
    }
}
?>