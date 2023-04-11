<?php
include('../database.php');
include("./send.php");

$date = new DateTime('now');

$date->format('Y-m-d');

$date1week = new DateTime($Date);

$date1week->sub(new DateInterval('P2W'));

$resultDate = $date1week->format('Y-m-d');

$MedicareNumbers = array();
$Workplaces = array();

$statement = $conn->prepare("SELECT Medicare_Number FROM(SELECT Medicare_Number, Facility_Name, Date, Start_Time, End_Time FROM Scheduled WHERE Date >= :date AND Date <=date1week)");
$statement->bindParam(':date', $date);
$statement->bindParam(':date1week', $date1week);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $MedicareNumbers[] = $row['Medicare_Number'];
}

$statement = $conn->prepare("SELECT Facility_Name FROM(SELECT Medicare_Number, Facility_Name, Date, Start_Time, End_Time FROM Scheduled WHERE Date >= :date AND Date <=date1week)");
$statement->bindParam(':date', $date);
$statement->bindParam(':date1week', $date1week);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $Workplaces[] = $row['Medicare_Number'];
}

$statement = $conn->prepare("SELECT Medicare_Number, Facility_Name, Date, Start_Time, End_Time FROM Scheduled WHERE Date >= :date AND Date <=date1week");
$statement->bindParam(':date', $date);
$statement->bindParam(':date1week', $date1week);
$statement->execute();
$results = $statement->fetchAll();

foreach ($MedicareNumbers as $mn) {


        foreach ($Workplaces as $wp) {

                $body = "";
                $Subject = $wp . " Schedule for " . $date . " to " . $date1week;

                for ($x = 0; $x < count($results); $x++) {

                        if ($results[$x]["Medicare_Number"] == $mn && $results[$x]["Facility_Name"] == $wp) {

                                $body = $body . $results[$x]["Date"] . ", Start time: " . $results[$x]["Start_Time"] . ", End time: " . $results[$x]["End_Time"] . "\n";
                        }
                }

                if (strlen($body) > 1) {

                        $statement = $conn->prepare("SELECT Email FROM hbc353_4.Employees WHERE Medicare_Number = :Medicare_Number");
                        $statement->bindParam(':Medicare_Number', $mn);
                        $statement->execute();
                        $employee = $statement->fetch(PDO::FETCH_ASSOC);
                        sendAndLog($mn, $employee["Email"], $wp, $Subject, $body);
                }
        }
}
?>