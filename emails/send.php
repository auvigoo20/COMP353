<?php
require_once "../database.php";
function sendAndLog($Medicare_Number, $Email, $Facility_Name, $Subject, $Body)
{
    
    $Date = date('Y-m-d');

    if (mail($Email, $Subject, $Body, "From:353Medical@hotmail.com")) {
        $statement = $conn->prepare("INSERT INTO hbc353_4.Email (Medicare_Number, Facility_Name, Date, Subject, Body) VALUES(:Medicare_Number, :Facility_Name, :Date, :Subject, :Body)");
        $statement->bindParam(':Medicare_Number', $Medicare_Number);
        $statement->bindParam(':Facility_Name', $Facility_Name);
        $statement->bindParam(':Subject', $Subject);
        $statement->bindParam(':Body', $Body);
        $statement->bindParam(':Date', $Date);
        $statement->execute();
        $employee = $statement->fetch(PDO::FETCH_ASSOC);
        
    }
}

?>