<?php

class ResetPassword extends Dbh {

    private $selector;
    private $validator;
    private $password;
    private $passwordRepeat;

    public function __construct($selector, $validator, $password, $passwordRepeat) {
        $this->selector = $selector;
        $this->validator = $validator;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function newPassword() {

        if (empty($this->password) || empty($this->passwordRepeat)) {
            header("location: ../create-new-password.php?selector=" . $this->selector . "&validator=" . $this->validator . "&newpwd=empty");
            exit();
        } else if ($this->password != $this->passwordRepeat) {
            header("location: ../create-new-password.php?selector=" . $this->selector . "&validator=" . $this->validator . "&newpwd=pwdnotsame");
            exit();
        } else if (strlen($this->password) < 8 || !preg_match("#[0-9]+#", $this->password) || !preg_match("#[A-Z]+#", $this->password) || !preg_match("#[a-z]+#", $this->password) || !preg_match('/[!@#$%^&*_=+-]/', $this->password)) {
            header("location: ../create-new-password.php?selector=" . $this->selector . "&validator=" . $this->validator . "&newpwd=invalidnewpassword");
            exit();
        }

        $sql = $this->connect()->prepare('SELECT * FROM pwdresets WHERE pwdResetSelector=? AND pwdResetExpires >= ?;');
        $currentDate = date("U");

        if (!$sql->execute(array($this->selector, $currentDate))) {
            $sql = null;
            header("location: ../reset-password.php?error=stmtfailed");
            exit();
        } else {

            if($sql->rowCount() == 0) {
                echo "You need to re-submit your reset request.";
                exit();
            } else {
                $user = $sql->fetchAll(PDO::FETCH_ASSOC);
                $tokenBin = hex2bin($this->validator);
                $tokenCheck = password_verify($tokenBin, $user[0]["pwdResetToken"]);

                if ($tokenCheck === false) {
                    echo "You need to re-submit your reset request.";
                    exit();
                } elseif ($tokenCheck === true) {
                    $tokenEmail = $user[0]["pwdResetEmail"];

                    $sql = $this->connect()->prepare('SELECT * FROM users WHERE email=?;');

                    if (!$sql->execute(array($tokenEmail))) {
                        $sql = null;
                        header("location: ../reset-password.php?error=stmtfailed");
                        exit();
                    } else {
                        if($sql->rowCount() == 0) {
                            echo "You need to re-submit your reset request.";
                            exit();
                        } else {
                            $sql = $this->connect()->prepare('UPDATE users SET password=? WHERE email=?;');
                            $newPwdHash = password_hash($this->password, PASSWORD_DEFAULT);
                            if (!$sql->execute(array($newPwdHash, $tokenEmail))) {
                                $sql = null;
                                header("location: ../reset-password.php?error=stmtfailed");
                                exit();
                            } else {
                                $sql = $this->connect()->prepare('DELETE FROM pwdresets WHERE pwdResetEmail=?;');
                                
                                if (!$sql->execute(array($tokenEmail))) {
                                    $sql = null;
                                    header("location: ../reset-password.php?error=stmtfailed");
                                    exit();
                                } else {
                                    $to = $tokenEmail;

                                    $subject = "Password Changed";
                                
                                    $message = 'Your password was successfully changed. <br> If you did not make this request, please secure your account.';
                                    $header .= "Content-type:text/html; charset=UTF-8\r\n";
                                
                                    mail($to, $subject, $message, $header);
                                
                                    header("location: ../login.php?newpwd=passwordupdated");

                                }
                            }
                        }
                    }

                }
            }

        }
    }

}