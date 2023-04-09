<?php
session_start();
$Medicare_Number = $_SESSION['Medicare_Number'];
$Facility_Name = $_SESSION['Facility_Name'];
$Subject = $_SESSION['Subject'];
$Body = $_SESSION['Body'];
$Date = date('Y-m-d');

$statement = $conn->prepare("SELECT Email FROM hbc353_4.Employees WHERE employee.Medicare_Number = :Medicare_Number");
$statement->bindParam(':Medicare_Number', $Medicare_Number);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);
$Email = $employee["Email"];
if (mail($Email, $Subject, $Body, "From:353Medical@hotmail.com")) {
    if(strlen($Body)>80){
        $Body=substr($Body, 0, 80);
    }
    $statement = $conn->prepare("INSERT INTO hbc353_4.Email (Medicare_Number, Facility_Name, Date, Subject, Body) VALUES(:Medicare_Number, :Facility_Name, :Date, :Subject, :Body)");
    $statement->bindParam(':Medicare_Number', $Medicare_Number);
    $statement->bindParam(':Facility_Name', $Facility_Name);
    $statement->bindParam(':Subject', $Subject);
    $statement->bindParam(':Body', $Body);
    $statement->bindParam(':Date', $Date);
    $statement->execute();
    $employee = $statement->fetch(PDO::FETCH_ASSOC);
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
}


?>