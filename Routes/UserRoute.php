<?
require_once PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
class UserRoute extends BaseRoute {
    public $var = "variable";
    protected function getPath(){
        $path = $this->getUriSegments();
        $path = explode('/user', $path);
        return $path;
    }

    public function callFunc(){
        $userCon = new UserController();
        $path = $this->getPath();
        // echo $path;
        // exit;
    }
}
?>
