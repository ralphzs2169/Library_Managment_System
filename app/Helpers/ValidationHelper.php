<?php
require_once __DIR__ . '/../Models/User.php';

class ValidationHelper {
    
    public static function validateSignupData($data) {
        $errors = [];

        // Validate each field using the respective methods
        $emailValidation = self::validateEmail($data['email'] ?? '');
        if ($emailValidation !== true) {
            $errors['email'] = json_decode($emailValidation, true)['invalid'];
        }

        $usernameValidation = self::validateUsername($data['username'] ?? '');
        if ($usernameValidation !== true) {
            $errors['username'] = json_decode($usernameValidation, true)['invalid'];
        }

        $passwordValidation = self::validatePassword($data['password'] ?? '', $data['confirm_password'] ?? '');
        if ($passwordValidation !== true) {
            $errors['password'] = json_decode($passwordValidation, true)['invalid'];
        }

        $contactValidation = self::validateContactNumber($data['contact_no'] ?? '');
        if ($contactValidation !== true) {
            $errors['contact_no'] = json_decode($contactValidation, true)['invalid'];
        }

        $firstNameValidation = self::validateName($data['firstname'] ?? '', 'First name');
        if ($firstNameValidation !== true) {
            $errors['firstname'] = json_decode($firstNameValidation, true)['invalid'];
        }

        $lastNameValidation = self::validateName($data['lastname'] ?? '', 'Last name');
        if ($lastNameValidation !== true) {
            $errors['lastname'] = json_decode($lastNameValidation, true)['invalid'];
        }

        $middleInitialValidation = self::validateMiddleInitial($data['middle_initial'] ?? '');
        if ($middleInitialValidation !== true) {
            $errors['middle_initial'] = json_decode($middleInitialValidation, true)['invalid'];
        }

        $roleValidation = self::validateRole($data['role'] ?? '');
        if ($roleValidation !== true) {
            $errors['role'] = json_decode($roleValidation, true)['invalid'];
        }

        if ($data['role'] === 'Student') {
            if (empty($data['student_no'])) {
                $errors['student_no'] = 'Student number is required';
            }
            if (empty($data['year_level'])) {
                $errors['year_level'] = 'Year level is required';
            }
            if (empty($data['department_id'])) {
                $errors['department_id'] = 'Department is required';
            }
        } else if ($data['role'] === 'Teacher') {
            if (empty($data['employee_no'])) {
                $errors['employee_no'] = 'Employee number is required';
            }
            if (empty($data['department_id'])) {
                $errors['department_id'] = 'Department is required';
            }
        }

        return empty($errors) ? null : $errors;
    }


    public static function validateEmail($email) {
        if (empty($email)) {
            return json_encode(['invalid' => 'Email is required']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['invalid' => 'Invalid email']);
        }

        if (User::findUserByEmailOrUsername($email)) {
            return json_encode(['invalid' => 'Email already exists']);
        }

        return true;
    }

    public static function validateUsername($username) {
        if (empty($username)) {
            return json_encode(['invalid' => 'Username is required']);
        }
        if (strlen($username) < 3 || strlen($username) > 20) {
            return json_encode(['invalid' => 'Username must be between 3 and 20 characters']);
        }
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            return json_encode(['invalid' => 'Invalid username']);
        }
        if (User::findUserByEmailOrUsername($username)) {
            return json_encode(['invalid' => 'Username already exists']);
        }
        return true;
    }

        public static function validatePassword($password, $confirmPassword) {
            if (empty($password)) {
                return json_encode(['invalid' => 'Password is required']);
            }
            if (strlen($password) < 6) {
                return json_encode(['invalid' => 'Password must be at least 6 characters']);
            }
            if ($password !== $confirmPassword) {
                return json_encode(['invalid' => 'Passwords do not match']);
            }
        return true;
    }

    public static function validateContactNumber($contact) {

        if (!empty($contact) && !preg_match('/^(09|\+639)\d{9}$/', $contact)) {
            return json_encode(['invalid' => 'Invalid contact number']);
        }
        return true;
    }

    public static function validateName($name, $fieldName) {
        if (empty($name)) {
            return json_encode(['invalid' => "$fieldName is required"]);
        }
        if (strlen($name) < 2 || strlen($name) > 50) {
            return json_encode(['invalid' => "$fieldName must be between 2 and 50 characters"]);
        }
        if (!preg_match('/^[a-zA-Z\s\-]+$/', $name)) {
            return json_encode(['invalid' => "Invalid $fieldName"]);
        }
        return true;
    }
    public static function validateMiddleInitial($middle_initial) {

         if (!empty($middle_initial) && !preg_match('/^[A-Z]\.?$/', $middle_initial)) {
            return json_encode(['invalid' => 'Invalid middle initial']);
        }
        return true;
    }
    
    public static function validateRole($role) {
        $validRoles = ['Staff', 'Librarian', 'Student', 'Teacher'];
        if (empty($role)) {
            return json_encode(['invalid' => 'Role is required']);
        }
        if (!in_array($role, $validRoles)) {
            return json_encode(['invalid' => 'Invalid role']);
        }
        return true;
    }

}