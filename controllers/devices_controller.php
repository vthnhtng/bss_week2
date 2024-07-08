<?php
require_once('controllers/base_controller.php');
require_once('models/device.php');

class DevicesController extends BaseController
{
    function __construct()
    {
        $this->folder = 'devices';
    }

    public function index()
    {
        require_once('controllers/login_controller.php');
        if (LoginController::isLoggedIn()) {
            $devices = Device::all();
            $data = array("devices" => $devices);
            $this->render("index", $data);
        } else {
            $this->redirect("login", "new");
        }
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $deviceName = $_POST["deviceName"];
            $deviceIP = $_POST["deviceIP"];
            $deviceMAC = $_POST["deviceMAC"];

            if (!Device::isValidMAC($deviceMAC)) {
                session_start();
                $_SESSION['create_error'] = "Invalid MAC Address";
                $this->redirect("devices", "index");
                return;
            }

            if (Device::isExistedMAC($deviceMAC)) {
                session_start();
                $_SESSION['create_error'] = "MAC Address is existed";
                $this->redirect("devices", "index");
                return;
            }


            if (!Device::isValidIP($deviceIP)) {
                session_start();
                $_SESSION["create_error"] = "Invalid IP Address";
                $this->redirect("devices", "index");
                return;
            }

            if (Device::isExistedIP($deviceIP)) {
                session_start();
                $_SESSION['create_error'] = "IP Address is existed";
                $this->redirect("devices", "index");
                return;
            }

            if (!Device::isValidName($deviceName)) {
                session_start();
                $_SESSION['create_error'] = "Device name cannot be empty";
                $this->redirect("devices", "index");
                return;
            }

            Device::create($deviceName, $deviceIP, $deviceMAC);
            $this->redirect("devices", "index");
        }
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["deviceId"];
            $deviceName = $_POST["deviceName"];
            $deviceMAC = $_POST["deviceMAC"];
            $deviceIP = $_POST["deviceIP"];
            $powerConsumption = $_POST["powerConsumption"];

            if (!Device::isValidMAC($deviceMAC)) {
                session_start();
                $_SESSION['update_error'] = "Invalid MAC Address";
                $this->redirect("devices", "index");
                return;
            }

            if (!Device::isValidIP($deviceIP)) {
                session_start();
                $_SESSION["update_error"] = "Invalid IP Address";
                $this->redirect("devices", "index");
                return;
            }

            if (!Device::isValidPowerConsumption($powerConsumption)) {
                session_start();
                $_SESSION["update_error"] = "Invalid Power Consumption Address";
                $this->redirect("devices", "index");
                return;
            }

            if (!Device::isValidName($deviceName)) {
                session_start();
                $_SESSION['update_error'] = "Device name cannot be empty";
                $this->redirect("devices", "index");
                return;
            }
            $result = Device::update($id, $deviceName, $deviceMAC, $deviceIP, $powerConsumption);

            if ($result) {
                $this->redirect("devices", "index");
            } else {
                $this->redirect("devices", "index");
            }
        } else {
            // TODO handle non post request
        }
    }

    public function delete()
    {
        if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
            $idToDelete = $_GET['id'];
            $result = Device::delete($idToDelete);

            if ($result) {
                $this->redirect("devices", "index");
            } else {
                $this->redirect("devices", "index");
            }
        } else {
            // TODO handle invalid request
        }
    }
}
