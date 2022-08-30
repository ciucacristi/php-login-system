<?php

class ResetRequestPassword extends Dbh {

    private $userEmail;
    private $selector;
    private $token;
    private $url;
    private $expires;

    public function __construct($userEmail, $selector, $token, $url, $expires) {
        $this->userEmail = $userEmail;
        $this->selector = $selector;
        $this->token = $token;
        $this->url = $url;
        $this->expires = $expires;
    }

    public function ResetRequest() {
        // Check if the user email exists
        $checkEmail = $this->connect()->prepare('SELECT * FROM users WHERE email = ?');

        if (!$checkEmail->execute(array($this->userEmail))) {
            $checkEmail = null;
            header("location: ../reset-password.php?error=stmtfailed");
            exit();
        }

        if($checkEmail->rowCount() == 0) {
            $checkEmail = null;
            header("location: ../reset-password.php?error=userdoesnotexist");
            exit();
        }

        $checkEmail = null;

        // Delete the previous requests details from database
        $sql = $this->connect()->prepare('DELETE FROM pwdresets WHERE pwdResetEmail=?;');

        if (!$sql->execute(array($this->userEmail))) {
            $sql = null;
            header("location: ../reset-password.php?error=stmtfailed");
            exit();
        }

        $sql = null;

        // Insert the new resets details into database
        $sql = $this->connect()->prepare('INSERT INTO pwdresets (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);');
        
        $hashedToken = password_hash($this->token, PASSWORD_DEFAULT);

        if (!$sql->execute(array($this->userEmail, $this->selector, $hashedToken, $this->expires))) {
            $sql = null;
            header("location: ../reset-password.php?error=stmtfailed");
            exit();
        }

        $sql = null;

        $to = $this->userEmail;
        $subject = "Reset your password";
        $message = 'We received a password reset request. The link to reset your password is below and will be available for 30 minutes. ' . "<br>" . 'If you did not make this request, you can ignore this email. ' . "<br><br>" . "<a href=".$this->url.">$this->url</a>";
        $header .= "Content-type:text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $header);

        header("location: ../reset-password.php?reset=success");
        
    } 

}