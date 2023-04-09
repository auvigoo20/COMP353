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
mail($Email,$Subject,$Body,"From:353Medical@hotmail.com");
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>