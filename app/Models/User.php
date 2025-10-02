<?php

class User {
    private $_userId, $_firstname, $_lastname, $_middle_initial, 
            $_username, $_email, $_contact, $_password,
            $_role, $_library_status, $_created_at, $_updated_at;
            
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Getters
    public function getUserId() { return $this->_userId; }
    public function getFirstName() { return $this->_firstname; }
    public function getLastName() { return $this->_lastname; }
    public function getMiddleInitial() { return $this->_middle_initial; }
    public function getUsername() { return $this->_username; }
    public function getEmail() { return $this->_email; }
    public function getContact() { return $this->_contact; }
    public function getPassword() { return $this->_password; }
    public function getRole() { return $this->_role; }
    public function getLibraryStatus() { return $this->_library_status; }
    public function getCreatedAt() { return $this->_created_at; }
    public function getUpdatedAt() { return $this->_updated_at; }

    // Setters
    public function setUserId($userId) { $this->_userId = $userId; }
    public function setFirstName($firstname) { $this->_firstname = $firstname; }
    public function setLastName($lastname) { $this->_lastname = $lastname; }    
    public function setMiddleInitial($middle_initial) { $this->_middle_initial = $middle_initial; }
    public function setUsername($username) { $this->_username = $username; }
    public function setEmail($email) { $this->_email = $email; }
    public function setContact($contact) { $this->_contact = $contact; }
    public function setPassword($password) { $this->_password = $password; }
    public function setRole($role) { $this->_role = $role; }
    public function setLibraryStatus($library_status) { $this->_library_status = $library_status; }
    public function setCreatedAt($created_at) { $this->_created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->_updated_at = $updated_at; }

    // Sign Up User
    public function signUp(){
        $this->db->query("INSERT INTO user (firstname, lastname, middle_initial, username, email, contact_no, password, role) 
                          VALUES (:firstname, :lastname, :middle_initial, :username, :email, :contact_no, :password, :role)");
        
        $this->db->bind(':firstname', $this->getFirstName());
        $this->db->bind(':lastname', $this->getLastName());
        $this->db->bind(':middle_initial', $this->getMiddleInitial());  
        $this->db->bind(':username', $this->getUsername());
        $this->db->bind(':email', $this->getEmail());
        $this->db->bind(':contact_no', $this->getContact());
        $this->db->bind(':password', password_hash($this->getPassword(), PASSWORD_BCRYPT));
        $this->db->bind(':role', $this->getRole());  

        if (!$this->db->execute()) {
           throw new Exception('Failed to insert user');
        }
        return $this->db->lastInsertId();
    }


    public static function findUserByEmailOrUsername($identifier) {
        $db = new Database();
        $db->query("SELECT * FROM user WHERE email = :identifier OR username = :identifier");
        $db->bind(':identifier', $identifier);
        return $db->single();
    }

    // Verify Login Credentials
    public function login($username, $password) {   

        $user = $this->findUserByEmailOrUsername($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getTest(){
        return "Hello World";
    }

}