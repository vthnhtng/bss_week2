<?php
namespace controllers\users_controller;
use controllers\base_controller\BaseController;

use models\User;
class UsersController extends BaseController
{
    function __construct()
    {
        $this->folder = 'users';
    }


    public function edit()
    {
        session_start();
        if (User::findById($_SESSION['userId'])->isLoggedIn()) {
            $this->render("edit");
        } else {
            $this->redirect("login", "new");
        }
    }

    public function update()
    {
        if (isset($_FILES['image'])) {
            echo "<pre>";
            print_r($_FILES['image']);
            echo "</pre>";

            $img_name = $_FILES['image']['name'];
            $img_size = $_FILES['image']['size'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if ($error === 0) {
                if ($img_size > 125000) {
                    $em = "File is too large.";
                    $this->redirect("users", "edit", $em);
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = 'uploads/' . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        // Insert into Database
                        $currentUser = User::findById($_POST['userId']);
                        $currentUser->update($new_img_name);

                        // header("Location: view.php");
                        $this->redirect("devices", "index");
                    } else {
                        $em = "You can't upload files of this type";
                        $this->redirect("users", "edit", $em);
                    }
                }
            } else {
                $em = "Invalid Image Upload!";
                $this->redirect("users", "edit", $em);
            }
        } else {
            $em = "Invalid Image Upload!";
            $this->redirect("users", "edit", $em);
        }
    }
}
