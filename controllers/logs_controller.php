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
            $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $recordsPerPage = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
            if ($recordsPerPage <= 0) {
                $recordsPerPage = 10;
            } 
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

            if ($keyword) {
                $logs = Log::search($keyword, $pageNumber, $recordsPerPage);
                $totalLogs = Log::getTotalLogsByKeyword($keyword);
            } else {
                $logs = Log::paginate($pageNumber, $recordsPerPage);
                $totalLogs = Log::getTotalLogs();
            }

            $totalPages = ceil($totalLogs / $recordsPerPage);

            $data = array(
                "logs" => $logs,
                "currentPage" => $pageNumber,
                "totalPages" => $totalPages,
                "keyword" => $keyword,
                "rows" => $recordsPerPage
            );

            $this->render("index", $data);
        } else {
            $this->redirect("login", "new");
        }
    }
}
