<?php require_once '../database.php'; 
$statement2 = $conn->prepare("DELETE FROM hbc353_4.Facilities WHERE Name = :Name;");
$statement2->bindParam(":Name", $_GET["Name"]);
$statement2->execute();
header("Location: .");
?>