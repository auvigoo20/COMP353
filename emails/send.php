<?php
function sendAndLog($Medicare_Number, $Email, $Facility_Name, $Subject, $Body)
{
    include('../database.php');
    
    $Date = date('Y-m-d');
    if(mail($Email, $Subject, $Body, "from:comp353health@gmail.com")){
        
    $statement = $conn->prepare("INSERT INTO hbc353_4.Email (Medicare_Number, Facility_Name, Date, Subject, Body, Employee_Email) VALUES(:Medicare_Number, :Facility_Name, :Date, :Subject, :Body, :Employee_Email)");
        $statement->bindParam(':Medicare_Number', $Medicare_Number);
        $statement->bindParam(':Facility_Name', $Facility_Name);
        $statement->bindParam(':Subject', $Subject);
        $statement->bindParam(':Body', $Body);
        $statement->bindParam(':Date', $Date);
        $statement->bindParam(':Employee_Email', $Email);
        $statement->execute();
        $employee = $statement->fetch(PDO::FETCH_ASSOC);

    
        
        header("Location: ../emails");
        
    }
    
}

?>