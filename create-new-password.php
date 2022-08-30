<?php
    include_once 'header.php';
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];
    if (!empty($selector) && !empty($validator)) {
?>

    <div class="container my-5 p-5">
        <h2 class="text-center">Create a new password</h2>
        <p class="text-center">Enter your new password:</p>

        <div class="col-lg-6 mx-auto my-5">
         <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if (empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                        <form action="inc/reset-password-inc.php" method="post">
                            <input type="hidden" name="selector" value="<?php echo $selector;?>">
                            <input type="hidden" name="validator" value="<?php echo $validator;?>">

                            <div class="mb-4">
                                <input type="password" name="newPassword" class="form-control" placeholder="Enter a new password">
                            </div>

                            <div class="mb-4">
                                <input type="password" name="repeatNewPassword" class="form-control" placeholder="Repeat the new password">
                            </div>

                            <button type="submit" name="reset-password-submit" class="btn btn-primary">Change password</button>
                        </form>

                    <?php
                }
            }
         ?>

        <br>
        <?php 
            if (isset($_GET["newpwd"])) {
                if ($_GET["newpwd"] == "empty") {
                    echo '<p class="text-danger">Please fill all fields!</p>';
                }
            }

            if (isset($_GET["newpwd"])) {
                if ($_GET["newpwd"] == "pwdnotsame") {
                    echo '<p class="text-danger">Passwords are not the same!</p>';
                }
            }

            if (isset($_GET["newpwd"])) {
                if ($_GET["newpwd"] == "invalidnewpassword") {
                    echo "<p class='text-danger'>Make sure your password contains at least 8 characters, a Capital letter, a number and a special charcter.</p>";
                }
            }
            
        ?>
        </div>
    </div>

<?php
    include_once 'footer.php';
?>

<?php
} else {
    header("location: reset-password.php");
    exit();
}
?>