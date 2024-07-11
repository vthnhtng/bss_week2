<?php
namespace models;
class Device
{
    public $id;
    public $name;
    public $MAC;
    public $IP;
    public $createdDate;
    public $powerConsumption;

    function __construct($id, $name, $MAC, $IP, $createdDate, $powerConsumption)
    {
        $this->id = $id;
        $this->name = $name;
        $this->MAC = $MAC;
        $this->IP = $IP;
        $this->createdDate = $createdDate ?? date("Y-m-d");
        $this->powerConsumption = $powerConsumption;
    }

    public static function all()
    {
        $devices = [];
        $db = DB::getInstance();
        $sql = "SELECT * FROM devices";
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $devices[] = new Device(
                $row['id'],
                $row['name'],
                $row['MAC'],
                $row['IP'],
                $row['createdDate'],
                $row['powerConsumption']
            );
        }

        return $devices;
    }

    public static function create($deviceName, $IP, $MAC)
    {
        $db = DB::getInstance();
        $powerConsumption = 0;
        $sql = "INSERT INTO devices (name, MAC, IP, powerConsumption) VALUES ('$deviceName', '$MAC', '$IP', $powerConsumption)";

        if ($db->query($sql) === TRUE) {
            return true;
        }
        echo "Error: " . $sql . "<br>" . $db->error;
        return false;
    }


    public static function delete($id)
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM devices WHERE id = '$id'";
        if ($db->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public static function update($id, $name, $MAC, $IP, $powerConsumption)
    {
        $db = DB::getInstance();
        $sql = "UPDATE devices SET 
                    name = '$name', 
                    MAC = '$MAC', 
                    IP = '$IP', 
                    powerConsumption = $powerConsumption 
                WHERE id = '$id'";

        if ($db->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error updating record: " . $db->error;
            return false;
        }
    }

    public static function isValidName($name)
    {
        return strlen($name) != 0;
    }
    public static function isValidIP($IP)
    {
        $pattern = '/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';

        return preg_match($pattern, $IP);
    }

    public static function isExistedIP($IP)
    {
        $db = DB::getInstance();

        $sql = 'SELECT COUNT(*) FROM devices WHERE IP = "' . $IP . '";';

        $result = $db->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['COUNT(*)'];
            if ($count > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function isValidMAC($MAC)
    {
        $pattern = '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/';
        return preg_match($pattern, $MAC);
    }

    public static function isExistedMAC($MAC)
    {
        $db = DB::getInstance();

        $sql = 'SELECT COUNT(*) FROM devices WHERE MAC = "' . $MAC . '";';

        $result = $db->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['COUNT(*)'];
            if ($count > 0) {
                return true;
            }
            return false;
        }
        return true;
    }

    public static function isValidPowerConsumption($PowerConsumption)
    {
        return is_numeric($PowerConsumption) && $PowerConsumption > 0;
    }

    public static function findById($id)
    {
        $db = DB::getInstance();

        $sql = "SELECT * FROM devices WHERE id = '$id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Device(
                $row['id'],
                $row['name'],
                $row['MAC'],
                $row['IP'],
                $row['createdDate'],
                $row['powerConsumption']
            );
        } else {
            return null;
        }
    }
}
