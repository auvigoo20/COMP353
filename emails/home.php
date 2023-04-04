<?php
require_once("../database.php");
include("functions.php");
session_start();
$Email=$_SESSION['Email'];
$Medicare_Number=$_SESSION['Medicare_Number'];
if(isset($_SESSION['Email'])&&isset($_SESSION['Medicare_Number'])){
    echo 'kjdf';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <!--add link to style sheet-->

</head>

<body>
    <h1>Welcome <?php echo $Email;?><h1>
</body>

</html>