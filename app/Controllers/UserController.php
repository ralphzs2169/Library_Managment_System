<?php
require_once '../Core/Controller.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    // Display all users
    public function index()
    {
        $users = $this->userModel->getAllUsers();
        $this->view('users/index', ['users' => $users]);
    }

    // Display a specific user
    public function show($id)
    {
        $user = $this->userModel->getUserById($id);
        $this->view('users/show', ['user' => $user]);
    }

    // Update a user (for admin or self-edit)
    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'role' => $_POST['role']
            ];

            if ($this->userModel->updateUser($data)) {
                header('Location: ' . URLROOT . '/users');
                exit;
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/edit', ['user' => $user]);
        }
    }

    // Delete a user
    public function delete($id)
    {
        if ($this->userModel->deleteUser($id)) {
            header('Location: ' . URLROOT . '/users');
            exit;
        } else {
            die('Something went wrong');
        }
    }

     // Example GET method
    public function test() {
        $result = $this->userModel->getTest();
        echo json_encode([
            'message' => $result
        ]);
    }
}


