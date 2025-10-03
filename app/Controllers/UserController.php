<?php
require_once __DIR__ . '/../Core/Controller.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model('User');
        
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Load user data from session if logged in
        if (isset($_SESSION['user_id'])) {
            $this->userModel->loadUserByID($_SESSION['user_id']);
        }
    }

    public function getFullname()
    {
        if (!isset($_SESSION['user_id'])) {
            return '';
        }
        
        $firstname = $this->userModel->getFirstName() ?? '';
        $middle_initial = $this->userModel->getMiddleInitial();

        if ($middle_initial) {
            $middle_initial = ' ' . $middle_initial . '.';
        }
        $lastname = $this->userModel->getLastName() ?? '';

        return trim($firstname . ' ' . $middle_initial . ' ' . $lastname);
    }

    public function getUserInformation(){
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return [
            'user_id' => $this->userModel->getUserId(),
            'firstname' => $this->userModel->getFirstName(),
            'lastname' => $this->userModel->getLastName(),
            'middle_initial' => $this->userModel->getMiddleInitial(),
            'fullname' => $this->getFullname(),
            'username' => $this->userModel->getUsername(),
            'email' => $this->userModel->getEmail(),
            'contact_no' => $this->userModel->getContact(),
            'role' => $this->userModel->getRole(),
            'library_status' => $this->userModel->getLibraryStatus(),
            'created_at' => $this->userModel->getCreatedAt(),
            'updated_at' => $this->userModel->getUpdatedAt()
        ];
    }

}


