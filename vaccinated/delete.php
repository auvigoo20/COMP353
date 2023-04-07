<?php require_once '../database.php'; 
$statement = $conn->prepare("DELETE FROM hbc353_4.Vaccinated
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Facility_Name = :Facility_Name AND
                                  Vaccine_Type = :Vaccine_Type AND
                                  Date = :Date AND
                                  Dose = :Dose;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Facility_Name", $_GET["Facility_Name"]);
$statement->bindParam(":Vaccine_Type", $_GET["Vaccine_Type"]);
$statement->bindParam(":Date", $_GET["Date"]);
$statement->bindParam(":Dose", $_GET["Dose"]);
$statement->execute();
header("Location: .");
?>