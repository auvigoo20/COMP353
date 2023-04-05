<?php
function check_login($conn){
    if(isset($_POST['Email'])&&isset($_POST['Medicare_Number'])){
        $Email=$_POST['Email'];
        $Medicare_Number=$_POST['Medicare_Number'];
        $check = $conn->prepare("select * from Employees where Medicare_Number = '$Medicare_Number' and Email = '$Email'");
        $check->execute();
        if(($check->rowCount()==1)){
            return $check->fetch(PDO::FETCH_ASSOC);
        }
    }
header("Location: login.php");

}