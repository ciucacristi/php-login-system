<?php 

class Login extends Dbh {

    protected function getUser($email, $password) {
        // Get all the user data for login
        $stmt = $this->connect()->prepare('SELECT * from users WHERE email = ?;');

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        }

        $hashedPass = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPass = password_verify($password, $hashedPass[0]["password"]);

        if ($_POST['rememberCheckbox'] == false) {
            unset($_COOKIE['passToken']);
            unset($_COOKIE['userId']);
            setcookie('passToken', '', time() - 3600, "/");
            setcookie('userId', '', time() - 3600, "/");

            $empty = "";
            $stmt = $this->connect()->prepare('UPDATE users SET passToken=? WHERE email= ?;');

            if (!$stmt->execute(array($empty, $email))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            $stmt = null;
        }

        if ($checkPass === false) {
            header("location: ../login.php?error=wrongpassword");
            exit();
    
        } else if ($checkPass === true) {

            $stmt = $this->connect()->prepare('SELECT * from users WHERE email = ?;');

            if (!$stmt->execute(array($email))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../login.php?error=wrongpassword");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // If all the login informations it's correctly, then login the user.
            session_start();
            $_SESSION["userid"] = $user[0]["userId"];
            $_SESSION["userEmail"] = $user[0]["email"];
            $_SESSION["userFirstName"] = $user[0]["firstName"];
            $_SESSION["userLastName"] = $user[0]["lastName"];
            $_SESSION["createdDate"] = $user[0]["created"];
            // If your database users table have more columns, add them here into SESSION variables.
    
            $stmt = null;
            header("location: ../index.php"); // <-- CHANGE THE LOCATION TO YOUR FIRST/PROFILE/ACCOUNT PAGE OF YOUR WEBSITE
            exit();
        }
    }

    // Encryption function
    protected function encrypt($data) {
        define("encryption_method", "AES-128-CTR");
        define("key", "4A404E635266546A576E5A7234753778");
        $key = key;
        $plaintext = $data;
        $ivlen = openssl_cipher_iv_length($cipher = encryption_method);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }

    // Decryption function
    protected function decrypt($data) {
        define("encryption_method", "AES-128-CTR");
        define("key", "4A404E635266546A576E5A7234753778");
        $key = key;
        $c = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher = encryption_method);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
    }
    
    protected function createLoginCookie($email) {
        // Remember Me Create Cookies
        $stmt = $this->connect()->prepare('SELECT * from users WHERE email = ?;');

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=wrongemail");
            exit();
        }

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST['rememberCheckbox'] == true) {
            // If the Remember Me checkbox it's checked, then create an new encrypted token and store into cookie and database.
            $passToken = bin2hex(random_bytes(16));
            $hashedpassTooken = password_hash($passToken, PASSWORD_DEFAULT);

            $stmt = $this->connect()->prepare('UPDATE users SET passToken=? WHERE email= ?;');
            if (!$stmt->execute(array($hashedpassTooken, $email))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            } else {
                setcookie('passToken', $passToken, time() + (86400 * 30), "/");
                setcookie('userId', $this->encrypt($user[0]['userId']), time() + (86400 * 30), "/");
                $stmt = null;
            }
        }
    }

    public function validToken() {
        // Check if the pass token from the cookies are = with the user token from the db and keep the user logged in
        if (isset($_COOKIE['userId']) && isset($_COOKIE['passToken'])) {
            
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE userId = ?;');

            if (!$stmt->execute(array($this->decrypt($_COOKIE['userId'])))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }
            
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $passToken = $user[0]["passToken"];
            $checkToken = password_verify($_COOKIE['passToken'], $passToken);

            if ($checkToken === false) {
                $stmt = null;
                exit();
            } else if ($checkToken === true) {
                // If all the login informations it's correctly, then login the user.
                session_start();
                $_SESSION["userid"] = $user[0]["userId"];
                $_SESSION["userEmail"] = $user[0]["email"];
                $_SESSION["userFirstName"] = $user[0]["firstName"];
                $_SESSION["userLastName"] = $user[0]["lastName"];
                $_SESSION["createdDate"] = $user[0]["created"];
                // If your database users table have more columns, add them here into SESSION variables.
        
                $stmt = null;
                header("location: index.php"); // <-- CHANGE THE LOCATION TO YOUR FIRST/PROFILE/ACCOUNT PAGE OF YOUR WEBSITE
                exit();
            }
        }
    }

    public function logout() {
        // Logout function
        if (isset($_COOKIE['userId'])) {
            $userId = $this->decrypt($_COOKIE['userId']);
        } else if (isset($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
        }
    
        $empty = "";
        $stmt = $this->connect()->prepare('UPDATE users SET passToken=? WHERE userId = ?;');

        if (!$stmt->execute(array($empty, $userId))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

}