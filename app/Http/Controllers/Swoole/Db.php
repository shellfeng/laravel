<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Chongqing');
//writelog();
class Db {

    private $_dsn = 'mysql:dbname=bi_sanguo_all;host=10.41.0.25;port=3306;';
    private $_user = 'cgm';
    private $_pwd = 'wEA11321sDf22E23';
    public $error;

    public function __construct($pid) {
        self::getDbObj($pid);
    }

    private function getDbObj($pid) {
        if (empty($this->dbObj)) {
            try{
                $this->dbObj = new PDO($this->_dsn, $this->_user, $this->_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';", PDO::ATTR_PERSISTENT=>true));
            }catch(Exception $e){
                print_r($e);
                exit();
            }

        }
    }

    public function insert($table, $params) {
        $fields = "";
        $values = "";
        $valuesArr = array();
        foreach ($params as $key => $value) {
            $fields .= (isset($a) ? "," : "") . "`$key`";
            $values .= (isset($a) ? "," : "") . ":$key";
            $valuesArr[":$key"] = $value;
            $a = 1;
        }
        $sql = "INSERT INTO $table ($fields) VALUES($values)";
        $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sth = $this->dbObj->prepare($sql);
        $sth->execute($valuesArr);
        $errorInfo = $sth->errorInfo();
        if ($errorInfo[2]) {
            $this->error = $errorInfo[2];
            return $errorInfo[2];
        } else {
            $this->error = '';
            return $this->dbObj->lastInsertId();
        }
    }

    public function findByDeviceId($table, $deviceId, $client_date) {
        $sql = "SELECT * FROM $table WHERE device_id=:device_id AND client_date=:client_date";
        $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sth = $this->dbObj->prepare($sql);
        $sth->bindParam(':device_id', $deviceId, PDO::PARAM_STR);
        $sth->bindParam(':client_date', $client_date, PDO::PARAM_STR);
        $sth->execute();
        $errorInfo = $sth->errorInfo();
        if ($errorInfo[2]) {
            $this->error = $errorInfo[2];
            return $errorInfo[2];
        }
        $this->error = '';
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($table, $condition, $param) {
        $sql = "UPDATE $table SET ";
        $set = '';
        foreach ($param as $key => $value) {
            $set .= (isset($a) ? "," : "") . "$key='" . str_replace("'", '', $value) . "'";
            $a = 1;
        }
        $conditionStr = '';
        foreach ($condition as $key => $value) {
            $conditionStr .= (isset($b) ? " AND " : "") . "$key='" . str_replace("'", '', $value) . "'";
            $b = 1;
        }
        $sql .= $set . " WHERE " . $conditionStr;
        return $this->dbObj->exec($sql);
    }

}