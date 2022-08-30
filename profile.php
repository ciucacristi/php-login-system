<?php
    include_once 'header.php';
?>

    <!-- Content -->
    <div class="container my-5 d-flex align-items-center justify-content-center">
        <div class="content my-5 p-5">

            <?php
                if (isset($_SESSION["userid"])) {
                    echo "First Name: <strong>" . $_SESSION['userFirstName'] . "</strong><br>";
                    echo "Last Name: <strong>" . $_SESSION['userLastName'] . "</strong><br>";
                    echo "Email: <strong>" . $_SESSION['userEmail'] . "</strong><br>";
                    echo "Created: <strong>" . $_SESSION['createdDate'] . "</strong><br>";

                } else {
                    header("location:". dirname("index.php"));
                    exit();
                }
            ?>
        </div>
    </div>

<?php
    include_once 'footer.php';
?>