<?php require_once '../database.php'; 

$statement1 = $conn->prepare("DELETE FROM hbc353_4.Lives WHERE Medicare_Number = :Medicare_Number;");
$statement1->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement1->execute();

$statement2 = $conn->prepare("DELETE FROM hbc353_4.Employees WHERE Medicare_Number = :Medicare_Number;");
$statement2->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement2->execute();
header("Location: .");
?>