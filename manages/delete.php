<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Manages 
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Facility_Name = :Facility_Name");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Facility_Name", $_GET["Facility_Name"]);
$statement->execute();
header("Location: .");
?>