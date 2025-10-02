<?php
require_once '../Core/Controller.php';
require_once '../Helpers/ValidationHelper.php';

class AuthController extends Controller{

    private $userModel;
    private $studentModel;
    private $teacherModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('User');
        $this->studentModel = $this->model('Student');
        $this->teacherModel = $this->model('Teacher');

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function signup(){
        // Only accept POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Read JSON body
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                echo json_encode(['error' => 'Invalid or missing JSON']);
                http_response_code(400);
                return;
            }

            try {
                // Check if database connection exists and supports transactions
                if ($this->db && method_exists($this->db, 'beginTransaction')) {
                    $this->db->beginTransaction();
                    $useTransaction = true;
                } else {
                    $useTransaction = false;
                }

                $invalidMessages = ValidationHelper::validateSignupData($data);

                if (!empty($invalidMessages)) {
                    if ($useTransaction && $this->db->inTransaction()) {
                        $this->db->rollBack();
                    }
                    echo json_encode(['status' => 'failed', 'errors' => $invalidMessages]);
                    http_response_code(422);
                    exit;
                }

                // Set values in your model
                $this->userModel->setFirstName($data['firstname']);
                $this->userModel->setLastName($data['lastname']);
                $this->userModel->setMiddleInitial($data['middle_initial']);
                $this->userModel->setUsername($data['username']);
                $this->userModel->setEmail($data['email']);
                $this->userModel->setContact($data['contact_no']);
                $this->userModel->setPassword($data['password']); // Hashed inside model
                $this->userModel->setRole($data['role'] ?? '');

                // Call model to save
                $user_id = $this->userModel->signUp(); 
                
                if (!$user_id) {
                    throw new Exception('Failed to insert user');
                }

                if ($data['role'] == 'Student') {
                    $student_no = htmlspecialchars($data['student_no'] ?? '');
                    $year_level = isset($data['year_level']) ? (int)$data['year_level'] : 1;
                    $department_id = (int)($data['department_id'] ?? 0);

                    $success = $this->studentModel->addStudent($user_id, $student_no, $year_level, $department_id);
                    if (!$success) {
                        throw new Exception('Failed to insert student information');
                    }
                } elseif ($data['role'] == 'Teacher') {
                    $employee_no = htmlspecialchars($data['employee_no'] ?? '');
                    $department_id = (int)($data['department_id'] ?? 0);

                    $success =$this->teacherModel->addTeacher($user_id, $employee_no, $department_id);
                    if (!$success) {
                        throw new Exception('Failed to insert teacher information');
                    }
                } 

                //Commit Transaction
                if ($useTransaction && $this->db->inTransaction()) {
                    $this->db->commit();
                }
                echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
                http_response_code(201);
                return;

            } catch (Exception $e) {
                if (isset($useTransaction) && $useTransaction && $this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                echo json_encode(['status' => 'failed', 'error' =>  $e->getMessage()]);
                http_response_code(500);
                return;
            }
        } else {
            echo json_encode(['error' => 'Method not allowed']);
            http_response_code(405);
            return;
        }
    }


    public function login(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Read JSON body
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                echo json_encode(['error' => 'Invalid or missing JSON']);
                http_response_code(400);
                exit;
            }

            $invalidMessages = ValidationHelper::validateLoginData($data);

            if (!empty($invalidMessages)) {
                echo json_encode(['status' => 'failed', 'errors' => $invalidMessages]);
                http_response_code(422);
                exit;
            }

            // Find username
            $user = $this->userModel->findUserByEmailOrUsername($data['username']);

            if (!$user) {
                echo json_encode(['status' => 'failed', 'errors' => ['username' => 'Username not found']]);
                http_response_code(422);
                exit;
            }
           
            if ($user && password_verify($data['password'], $user->password)) {
                // Login successful
                // Set session variables
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['email'] = $user->email;
                $_SESSION['role'] = $user->role;
                
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
                http_response_code(200);
                exit;
            } else {
                echo json_encode(['status' => 'failed', 'errors' => ['password' => 'Invalid Password']]);
                http_response_code(422);
                exit;
            }

        } else {
            $this->view('auth/login');
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . URLROOT . '/auth/login');
        exit;
    }
}
