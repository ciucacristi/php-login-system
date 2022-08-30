<?php
    include_once 'header.php';
?>

<?php if (!isset($_SESSION['userid'])) { ?>

    <div class="container my-5 p-5">
        <h2 class="text-center">Login</h2>

       <div class="col-lg-6 mx-auto my-5">
            <!-- Login Form -->
            <form action="inc/login-inc.php" method="post">
                
                <div class="mb-4">
                    <input type="email" name="email" class="form-control <?php if (isset($_GET["error"])) { if ($_GET["error"] == "wrongemail" || $_GET["error"] == "emptylogininputs" || $_GET["error"] == "invalidloginemail") { echo 'is-invalid'; } } ?>" placeholder="Email">
                </div>

                <div class="mb-4">
                    <input type="password" name="password" class="form-control <?php if (isset($_GET["error"])) { if ($_GET["error"] == "wrongpassword" || $_GET["error"] == "emptylogininputs" || $_GET["error"] == "invalidloginpassword") { echo 'is-invalid'; } } ?>" placeholder="Password">
                </div>

                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" name="rememberCheckbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>

                <a href="reset-password.php">Forgot your password?</a>
                <br><br>
                <button type="submit" name="submitLogin" class="btn btn-primary">Submit</button>
            </form>
            <br>
            <?php 
                // Displaying error messages
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptylogininputs") {
                        echo "<p class='text-danger'>Fill in all fields!</p>";
                    } else if ($_GET["error"] == "wrongemail") {
                        echo "<p class='text-danger'>This email does not exist!</p>";
                    } else if ($_GET["error"] == "invalidloginemail") {
                        echo "<p class='text-danger'>Please enter a valid email!</p>";
                    }  else if ($_GET["error"] == "wrongpassword") {
                        echo "<p class='text-danger'>Incorrect password!</p>";
                    } else if ($_GET["error"] == "invalidloginpassword") {
                        echo "<p class='text-danger'>Make sure your password contains at least 8 characters, a Capital letter, a number and a special charcter.</p>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<p class='text-danger'>Something went wrong, try again later!</p>";
                    } 
                }
            ?>

            <?php
                if (isset($_GET["newpwd"])) {
                    if ($_GET["newpwd"] == "passwordupdated") {
                        echo "<p class='text-success'>Your password has been changed!</p>";
                    }
                }
            ?>
       </div>
    </div>

<?php } else {
    header("location:". dirname("index.php"));
    exit();
} ?>

<?php
    include_once 'footer.php';
?>