<?php

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;

    private $dbh; //Database handler
    private $error; //for storing error messages
    private $stmt; //Statement handler

    public function __construct() {
        // Load config relative to this file
        $configPath = __DIR__ . '/../../config/config.php';
        if (!file_exists($configPath)) {
            error_log("Config file not found: $configPath", 3, __DIR__ . '/../../logs/app.log');
            die('Configuration file missing. Check config/config.php');
        }
        require_once $configPath;

        // Ensure DB constants exist
        if (defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && defined('DB_NAME')) {
            $this->host   = DB_HOST;
            $this->user   = DB_USER;
            $this->pass   = DB_PASS;
            $this->dbname = DB_NAME;
        } else {
            error_log('DB constants not defined in config file', 3, __DIR__ . '/../../logs/app.log');
            die('Database configuration incomplete. Check config/config.php');
        }

        //Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $logfile = defined('LOGFILE') ? LOGFILE : (__DIR__ . '/../../logs/app.log');
            error_log($this->error, 3, $logfile);
            die('Database connection failed. Please check the log file for details.');
        }
    }

    //Prepare statement with query
    public function query($sql) {   
        $this->stmt = $this->dbh->prepare($sql);
    }   

    //Binds Values to query
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

     // Execute prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get multiple rows
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single row
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get affected row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Last inserted ID
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

}