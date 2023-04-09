<?php require_once '../database.php'; 
$statement2 = $conn->prepare("DELETE FROM hbc353_4.Employees WHERE Medicare_Number = :Medicare_Number;");
$statement2->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement2->execute();
header("Location: .");
?> 