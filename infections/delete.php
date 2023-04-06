<?php require_once '../database.php'; 
$statement2 = $conn->prepare("DELETE FROM hbc353_4.Infections WHERE Type = :Type;");
$statement2->bindParam(":Type", $_GET["Type"]);
$statement2->execute();
header("Location: .");
?>