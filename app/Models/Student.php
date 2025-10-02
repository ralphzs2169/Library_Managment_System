<?php

require_once 'User.php';

class Student extends User {
    private $_student_no, $_year_level, $_department_id;

    public function __construct() {
        parent::__construct();
    }

    // Getters and setters
    public function getStudentNumber() { return $this->_student_no; }
    public function getYearLevel() { return $this->_year_level; }
    public function getDepartmentId() { return $this->_department_id; }

    public function setStudentNumber($student_no) { $this->_student_no = $student_no; }
    public function setYearLevel($year_level) { $this->_year_level = $year_level; }
    public function setDepartmentId($department_id) { $this->_department_id = $department_id; }

    // Add student record (linked to a user)
    public function addStudent($user_id, $student_no, $year_level, $department_id) {
        $this->db->query("INSERT INTO student (user_id, student_no, year_level, department_id) 
                          VALUES (:user_id, :student_no, :year_level, :department_id)");

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':student_no', $student_no);
        $this->db->bind(':year_level', $year_level);
        $this->db->bind(':department_id', $department_id);

        return $this->db->execute();
    }

    public function getStudentByUserId($user_id) {
        $this->db->query("SELECT u.*, s.student_id, s.year_level, s.department_id
                          FROM users u
                          INNER JOIN student s ON u.id = s.user_id
                          WHERE u.id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }
}
