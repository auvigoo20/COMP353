<?php
include("../database.php");
if(isset($_POST['Email'])&&isset($_POST['Medicare_Number'])){
    $Email=$_POST['Email'];
    $Medicare_Number=$_POST['Medicare_Number'];
    $check = $conn->prepare("select * from Employees where Medicare_Number = '$Medicare_Number' and Email = '$Email'");
    $check->execute();
    if(($check->rowCount()==1)){
        header("Location: home.php");
    }
    else{
        echo '<script>
                window.location.href = "index.php";
                alert("Invalid Login")
             </script>';
    }
}
?>
