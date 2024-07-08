<?php
require_once('controllers/base_controller.php');
require_once('models/log.php');
require_once('models/device.php');

class LogsController extends BaseController
{
    function __construct()
    {
        $this->folder = 'logs';
    }

    public function index()
    {
        require_once('controllers/login_controller.php');
        if (LoginController::isLoggedIn()) {
            $logs = Log::all();
            $data = array("logs" => $logs);
            $this->render("index", $data);
        } else {
            $this->redirect("login", "new");
        }
    }
}
