<?php

class SignupController extends Signup {

    private $firstName; 
    private $lastName; 
    private $email;
    private $password;
    private $repeatPassword;

    public function __construct($firstName, $lastName, $email, $password, $repeatPassword) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->repeatPassword = $repeatPassword;
    }

    public function signupUser() {
        // Check if exist empty inputs
        if ($this->emptyInputSignup() !== false) {
            header('location: ../signup.php?error=signupemptyinputs');    
            exit();
        }

        // Check if email it's valid
        if ($this->invalidEmail() !== false) {
            header('location: ../signup.php?error=invalidemail');
            exit();
        }

        // Check if passwords match
        if ($this->passMatch() !== false) {
            header('location: ../signup.php?error=passwordsdontmatch');
            exit();
        }

        // Check if email exist
        if ($this->checkUser($this->email) !== false) {
            header('location: ../signup.php?error=emailtaken');
            exit();
        }

        // Check if the password it's valid
        if ($this->passValidation() !== false) {
            header('location: ../signup.php?error=invalidpassword');
            exit();
        }

        $this->setUser($this->firstName, $this->lastName, $this->email, $this->password);
    }

    private function emptyInputSignup() {
        // Check for empty inputs in Signup form
        $result;

        if (empty($this->firstName) || empty($this->lastName) || empty($this->email) || empty($this->password) || empty($this->repeatPassword)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail() {
        // Email validation
        $result;

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
    
        return $result;
    }

    private function passMatch() {
        // Check if the passwords match
        $result;

        if ($this->password !== $this->repeatPassword) {
            $result = true;
        } else {
            $result = false;
        }
    
        return $result;
    }

    private function passValidation() {
        // Check if the password it's valid
        $result;

        if (strlen($this->password) < 8 || !preg_match("#[0-9]+#", $this->password) || !preg_match("#[A-Z]+#", $this->password) || !preg_match("#[a-z]+#", $this->password) || !preg_match('/[!@#$%^&*_=+-]/', $this->password)) {
            $result = true;
        } else {
            $result = false;
        } 
    
        return $result;
    }

}