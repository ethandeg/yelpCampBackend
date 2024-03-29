<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '.php', $uri )[1];
$path = explode('/',$uri);
switch($path[1]){
    case 'user':
        require_once PROJECT_ROOT_PATH . "/Routes/UserRoute.php";
        $user = new UserRoute();
        $user->callFunc();
        break;
    case 'camp':
        require_once PROJECT_ROOT_PATH . "/Routes/CampRoute.php";
        $camp = new CampRoute();
        $camp->callFunc();
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}
// if ((isset($uri[4]) && $uri[4] != 'user') || !isset($uri[4])) {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }


?>