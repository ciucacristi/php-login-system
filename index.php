<?php
    include_once 'header.php';
?>

    <!-- Content -->
    <div class="container my-5 d-flex align-items-center justify-content-center">
        <div class="content my-5 p-5">

            <?php
                if (isset($_SESSION["userid"])) {
                    echo "<h1>Hello, " . $_SESSION['userFirstName'] . "!</h1>";
                } else {
                    echo "<h1>Hello, world!</h1>";
                }
            ?>
        </div>
    </div>

<?php
    include_once 'footer.php';
?>