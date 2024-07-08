<?php
$controllers = array(
    "login" => ["new", "create"],
    "devices" => ["index", "create", "delete", "update"],
    "logs" => ["index"],
); 
if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = "pages";
    $action = "error";
}

include_once("controllers/" . $controller . "_controller.php");
$controllerClass = str_replace("_", "", ucwords($controller, "_")) . "Controller";
$controller = new $controllerClass;
$controller->$action();
