<?php
class Log
{
    public $id;
    public $deviceId;
    public $logAction;
    public $logDate;

    function __construct($id, $deviceId, $logAction, $logDate)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->logAction = $logAction;
        $this->logDate = $logDate ?? date("Y-m-d");
    }

    public static function all()
    {
        $logs = [];
        $db = DB::getInstance();
        $sql = "SELECT * FROM logs ORDER BY logDate";
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $logs[] = new Log(
                $row['id'],
                $row['deviceId'],
                $row['logAction'],
                $row['logDate']
            );
        }

        return $logs;
    }

    public static function paginate($pageNumber, $recordsPerPage)
    {
        $logs = [];
        $db = DB::getInstance();
        $offset = ($pageNumber - 1) * $recordsPerPage;
        $sql = "SELECT * FROM logs ORDER BY logDate LIMIT $offset, $recordsPerPage;";
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $logs[] = new Log(
                $row['id'],
                $row['deviceId'],
                $row['logAction'],
                $row['logDate']
            );
        }

        return $logs;
    }

    public static function search($keyword, $pageNumber, $recordsPerPage)
    {
        $logs = [];
        $db = DB::getInstance();
        $offset = ($pageNumber - 1) * $recordsPerPage;
        $sql = "SELECT logs.*, devices.name as deviceName FROM logs
                JOIN devices ON logs.deviceId = devices.id
                WHERE devices.name LIKE '%$keyword%'
                ORDER BY logs.logDate
                LIMIT $offset, $recordsPerPage;";
                
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $logs[] = new Log(
                $row['id'],
                $row['deviceId'],
                $row['logAction'],
                $row['logDate']
            );
        }

        return $logs;
    }

    public static function getTotalLogs()
    {
        $db = DB::getInstance();

        $sql = 'SELECT COUNT(*) FROM logs;';

        $result = $db->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['COUNT(*)'];
            return $count;
        }
        return 0;
    }

    public static function getTotalLogsByKeyword($keyword)
    {
        $db = DB::getInstance();

        $sql = "SELECT COUNT(*) as total FROM logs
                JOIN devices ON logs.deviceId = devices.id
                WHERE devices.name LIKE '%$keyword%';";
        $result = $db->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['total'];
            return $count;
        }
        return 0;
    }
}
