<?php
session_start();
require_once("../database.php");
include("functions.php");

?>
<!DOCTYPE html>
<html>

<head>
    <title> Login</title>
    <!--add link to style sheet-->

</head>

<body>
    <form action=login.php method="post">
        <?php if (isset($_GET['error'])) { ?>
            <p class="error">
                <?php echo $_GET['error']; ?>
            </p>
        <?php } ?>
        <input type="text" name="Email" placeholder="Email"><br>
        <input type="text" name="Medicare_Number" placeholder="Medicare Number"><br>
        <button type="submit" name="submit">Login</button>
</body>

</html>