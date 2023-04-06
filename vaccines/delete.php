<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Vaccines WHERE Type = :Type;");
$statement->bindParam(":Type", $_GET["Type"]);
$statement->execute();
header("Location: .");
?>