<?php
use tungvt\controllers\base_controller\BaseController;

$controllers = array(
    "login" => ["new", "create", "destroy"],
    "devices" => ["index", "create", "delete", "update"],
    "logs" => ["index", "new", "create"],
    "users" => ["edit", "update"]
); 


if (isset($_GET["controller"]) && array_key_exists($_GET["controller"], $controllers)) {
    $controller = $_GET["controller"];
    if (isset($_GET["action"]) && in_array($_GET["action"], $controllers[$controller])) {
        $action = $_GET["action"];
    } else {
        $action = "index"; 
    }
}

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = "pages";
    $action = "error";
}

include_once("controllers/" . $controller . "_controller.php");

$controllerClass = str_replace("_", "", ucwords($controller, "_")) . "Controller";
$controller = new $controllerClass;
$controller->$action();
