<?php
namespace controllers\login_controller;
use controllers\base_controller\BaseController;
use models\User;

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
            $password = $_POST["password"];
            $user = User::findByUsername($username, $password);
            if ($user) {
                $_SESSION['userId'] = $user->id;
                $this->redirect("devices", "index");
            } else {
                $data = array(
                    "error" => "<h1>Invalid username or password</h1>"
                );
                $this->render("new", $data);
            }
        }
    }


    public function destroy()
    {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect("login", "new");
    }
}
