<?php
namespace controllers\base_controller;
class BaseController
{
    protected $folder;
    function render($file, $data = array())
    {
        $view_file = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($view_file)) {
            extract($data);
            require_once($view_file);
        } else {
            header('Location: index.php?controller=pages&action=error');
        }
    }

    function redirect($controller, $action, $error = "")
    {
        if ($error != "") {
            header("Location: index.php?controller=$controller&action=$action&error=$error");
        } else {
            header("Location: index.php?controller=$controller&action=$action");
        }
    }
}
