<?php

class Signup extends Dbh {

    protected function setUser($firstName, $lastName, $email, $password) {
        // Create account
        $stmt = $this->connect()->prepare('INSERT INTO users (firstName, lastName, email, password, created) VALUES (?, ?, ?, ?, ?)');

        $createdDate = date("Y-m-d H:i");
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($firstName, $lastName, $email, $hashedPass, $createdDate))) {
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
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