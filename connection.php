<?php
class DB
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                require_once("config.php");
                self::$instance = new mysqli($db_hostname, $db_username, $db_password, $db_name);
                // Check for connection error
                if (self::$instance->connect_error) {
                    throw new Exception("Connection failed: " . self::$instance->connect_error);
                }
                // Set character set to utf8
                self::$instance->set_charset("utf8");
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        return self::$instance;
    }
}
