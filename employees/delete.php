<?php require_once '../database.php'; 

$statement = $conn->prepare("DELETE FROM hbc353_4.Employees WHERE Medicare_Number = :Medicare_Number;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->execute();
header("Location: .");
?>