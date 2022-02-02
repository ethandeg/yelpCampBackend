<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '.php', $uri )[1];
$path = explode('/',$uri);
switch($path[1]){
    case 'user':
        echo "we hit users route";
        // include "./Routes/UserRoute.php";
        // if ( ! class_exists('UserRoute')){
        //     die('There is no hope!');
        // } 
        // $userRoute = new UserRoute();
        // echo $userRoute;
        // $userRoute->callFunc();
        // require_once PROJECT_ROOT_PATH . "/Routes/BaseRoute.php";
        // $objFeedController = new BaseRoute();
        break;
    default:
        echo "default route";
        $objFeedController = new UserController();
}
// if ((isset($uri[4]) && $uri[4] != 'user') || !isset($uri[4])) {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }

//implement a switch case to include the controller needed based off the routes
// /user would give UserController
// in UserController, have seperate functions, based off what the next argument is
//get /user => list users
//get /user/:userId => list info about specific users
// post /user => create user

// $baseControl = new BaseController($uri);
// echo $baseControl->getUriSegments();
// print_r($_SERVER);
// $objFeedController = new UserController();
// $strMethodName = $uri[4] . 'Action';
// $objFeedController->{$strMethodName}();
?>