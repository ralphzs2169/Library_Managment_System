<?php

require_once 'User.php';

class Teacher extends User {
    private $_employee_no, $_department_id;

    public function __construct() {
        parent::__construct();
    }

    // Getters and setters
    public function getEmployeeNo() { return $this->_employee_no; }
    public function getDepartmentId() { return $this->_department_id; }

    public function setEmployeeNo($employee_no) { $this->_employee_no = $employee_no; }
    public function setDepartmentId($department_id) { $this->_department_id = $department_id; }

    // Add teacher record (linked to a user)
    public function addTeacher($user_id, $employee_no, $department_id) {
        $this->db->query("INSERT INTO teacher (user_id, employee_no, department_id) 
                          VALUES (:user_id, :employee_no, :department_id)");

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':employee_no', $employee_no);
        $this->db->bind(':department_id', $department_id);

        return $this->db->execute();
    }

    public function getTeacherByUserId($user_id) {
        $this->db->query("SELECT u.*, t.teacher_id, t.department_id
                          FROM users u
                          INNER JOIN teacher t ON u.id = t.user_id
                          WHERE u.id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }
}   