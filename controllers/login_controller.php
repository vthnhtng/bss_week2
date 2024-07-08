<?php
require_once('controllers/base_controller.php');

class LoginController extends BaseController
{
    function __construct()
    {
        $this->folder = "login";
    }

    public function new()
    {
        $this->render('new');
    }

    public function create()
    {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST['password'];

            if ($username == "john" && $password == "1234") {
                $_SESSION['username'] = 'john';
                $this->redirect("devices", "index");
            } else {
                $data = array(
                    "error" => "<h1>Invalid username or password</h1>"
                );
                $this->render("new", $data);
            }
        }
    }

    public static function isLoggedIn()
    {
        session_start();
        if (isset($_SESSION) && $_SESSION["username"]) {
            return true;
        }
        return false;
    }
}
