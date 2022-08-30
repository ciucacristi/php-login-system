<?php

class LoginController extends Login {
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function loginUser() {
        // Check if exist empty inputs
        if ($this->emptyInputLogin() !== false) {
            header('location: ../login.php?error=emptylogininputs');    
            exit();
        }

        // Check if email it's valid
        if ($this->invalidEmail($this->email) !== false) {
            header('location: ../login.php?error=invalidloginemail');
            exit();
        }

        // Check if the user email exist
        if ($this->checkUser($this->email) !== true) {
            header("location: ../login.php?error=wrongemail");
            exit();
        }

        // Check if the password it's valid
        if ($this->passValidation($this->password) !== false) {
            header('location: ../login.php?error=invalidloginpassword');
            exit();
        }
        
        $this->createLoginCookie($this->email);

        $this->getUser($this->email, $this->password);
    }

    private function emptyInputLogin() {
        // Check for empty inputs in Signin form
        $result;

        if (empty($this->email) || empty($this->password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail($email) {
        // Email validation
        $result;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

    protected function checkUser($email) {
        // Check if the email exist and get all the user data
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ?;');

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
   
        $result;
        if ($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    

}