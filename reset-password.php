<?php
    include_once 'header.php';
?>

    <div class="container my-5 p-5">
        <h2 class="text-center">Reset your password</h2>
        <p class="text-center">An email will be sent to you with instructions on how to reset your password.</p>
       
        <div class="col-lg-6 mx-auto my-5">
            <!-- Login Form -->
            <form action="inc/reset-request-inc.php" method="post">
                
                <div class="mb-4">
                    <input type="email" name="resetEmail" class="form-control <?php if (isset($_GET["error"])) { if ($_GET["error"] == "userdoesnotexist") { echo 'is-invalid'; } } ?>" placeholder="Email" required>
                </div>

                <button type="submit" name="reset-request-submit" class="btn btn-primary">Send</button>

                <br><br>
                <?php 
                    if (isset($_GET["reset"])) {
                        if ($_GET["reset"] == "success") {
                            echo '<p class="text-success">Check your email!</p>';
                        }
                    }

                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "userdoesnotexist") {
                            echo '<p class="text-danger">There is no account created with this email!</p>';
                        }
                    }

                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo '<p class="text-danger">It seems that an error has occurred!</p>';
                        }
                    }
                ?>
            </form>

       </div>
    </div>

<?php
    include_once 'footer.php';
?>