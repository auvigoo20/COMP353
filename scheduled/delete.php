<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Scheduled
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Facility_Name = :Facility_Name AND
                                  Date = :Date AND
                                  Start_Time = :Start_Time;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Facility_Name", $_GET["Facility_Name"]);
$statement->bindParam(":Date", $_GET["Date"]);
$statement->bindParam(":Start_Time", $_GET["Start_Time"]);
$statement->execute();
header("Location: .");
?>