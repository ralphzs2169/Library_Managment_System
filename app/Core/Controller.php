<?php

class Controller {

    protected $db;

    public function __construct() {
        require_once __DIR__ . '/Database.php';
        
        try {
            $database = new Database();
            $this->db = $database->dbh; // Assign PDO instance
            
            // Validate that we have a proper PDO connection
            if (!$this->db instanceof PDO) {
                error_log('Database connection failed: PDO instance not created', 3, __DIR__ . '/../../logs/app.log');
                throw new Exception('Database connection failed');
            }
        } catch (Exception $e) {
            error_log('Controller database initialization error: ' . $e->getMessage(), 3, __DIR__ . '/../../logs/app.log');
            echo json_encode(['status' => 'failed', 'error' => 'Database connection error. Please check the configuration and try again.']);
            exit;
        }
    }

    //Load a model
    public function model($model) {
        //Require model file
        require_once __DIR__ . '/../Models/' . $model . '.php';

        //Instantiate model
        return new $model($this->db);
    }

    //Load a view
    public function view($view, $data = []) {
        //Check for view file
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            //View does not exist
            echo json_encode(['status' => 'failed', 'error' => 'View does not exist']);
            exit;
        }
    }
}