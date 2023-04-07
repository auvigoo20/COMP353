<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Infected
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Infection_Type = :Infection_Type AND
                                  Date = :Date;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Infection_Type", $_GET["Infection_Type"]);
$statement->bindParam(":Date", $_GET["Date"]);
$statement->execute();
header("Location: .");
?>