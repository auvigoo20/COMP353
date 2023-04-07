<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Works 
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Facility_Name = :Facility_Name AND
                                  Start_Date = :Start_Date;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Facility_Name", $_GET["Facility_Name"]);
$statement->bindParam(":Start_Date", $_GET["Start_Date"]);
$statement->execute();
header("Location: .");
?>