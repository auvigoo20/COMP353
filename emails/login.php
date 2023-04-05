<?php
session_start();
include("../database.php");
if(isset($_POST['Email'])&&isset($_POST['Medicare_Number'])){
    $Email=$_POST['Email'];
    $Medicare_Number=$_POST['Medicare_Number'];
    $check = $conn->prepare("select * from Employees where Medicare_Number = '$Medicare_Number' and Email = '$Email'");
    $check->execute();
    if(($check->rowCount()==1)){
        $row = $check->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        if($row["Email"]==$Email&&$row["Medicare_Number"]==$Medicare_Number){
            $_SESSION['Email']=$row["Email"];
            $_SESSION['Medicare_Number']=$row["Medicare_Number"];
            header("Location: home.php");
        }else{
            echo '<script>
                    window.location.href = "index.php";
                    alert("Invalid Login")
                 </script>';
        }
    }
    }
    else{
        echo '<script>
                window.location.href = "index.php";
                alert("Invalid Login")
             </script>';
    }

?>
