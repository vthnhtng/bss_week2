<?php
namespace controllers\logs_controller;
use controllers\base_controller\BaseController;
use models\Log;
use models\Device;
use models\User;
class LogsController extends BaseController
{
    function __construct()
    {
        $this->folder = 'logs';
    }
    public function index()
    {
        session_start();
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $user = User::findById($_SESSION['userId']);
            if ($user) {
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
                return;
            }
        }
        $this->redirect("login", "new");
    }

    public function new() {
        if (isset($_GET['deviceId'])) {
            $deviceId = intval($_GET['deviceId']);
            $device = Device::findById($deviceId);
            $statusLog = Log::getLastStatus($deviceId); // Assume you have a method to get last status log
        
            echo json_encode([
                'deviceId' => $device->id,
                'name' => $device->name,
                'action' => $statusLog['logAction'],
                'lastTimeAction' => $statusLog['logDate']
            ]);
        }    
    }

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {;
            $deviceId = $_POST["deviceId"];
            $logAction = $_POST["logAction"];
            Log::create($deviceId, $logAction);
        }
        $this->redirect("logs", "index");
    }
}
