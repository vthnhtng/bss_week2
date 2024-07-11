<?php
namespace models;
class User
{
    public $id;
    public $username;
    public $avatar;

    function __construct($id, $username, $avatar)
    {
        $this->id = $id;
        $this->username = $username;
        $this->avatar = $avatar;
    }

    public function update($avatar_url)
    {
        $db = DB::getInstance();

        $sql = "UPDATE users SET avatar_url = '$avatar_url' WHERE id = '$this->id';";
        $result = $db->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getAvatarUrl() {
        $db = DB::getInstance();
        $sql = "SELECT avatar_url FROM users WHERE id = '$this->id';";
        $result = $db->query($sql);
        

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['avatar_url'];
        } else {
            return null;
        }
    }

    public static function findById($id)
    {
        $db = DB::getInstance();

        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new User(
                $row['id'],
                $row['username'],
                $row['avatar'],
            );
        } else {
            return null;
        }
    }

    public static function findByUsername($username, $password) {
        $db = DB::getInstance();
        $sql = ("SELECT id, password FROM users WHERE username = '$username';");
        $result = $db->query($sql);
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password == $user['password']) {
                return new User($user['id'], $user['username'], $user['avatar']);
            } else {
                return null;
            }  
        }
        return null;
    }

    public function isLoggedIn() {
        session_start();
        if (isset($_SESSION['userId']) && $_SESSION['userId'] == $this->id) {
            return true;
        }
        return false;
    }
}
