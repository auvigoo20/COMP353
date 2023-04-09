<?php require_once '../database.php';
// THIS IS A SAMPLE FILE USED FOR REFERENCE. ACTUAL CODE NEEDS TO BE RE-WRITTEN AND REFACTORED TO SATISFY THE REQUIREMENTS
$statement = $conn->prepare("SELECT e.First_Name, e.Last_Name, i.Date, w.Facility_Name
                            FROM hbc353_4.Employees e, hbc353_4.Infected i, hbc353_4.Works w
                            WHERE e.Medicare_Number = i.Medicare_Number 
                                AND e.Medicare_Number = w.Medicare_Number 
                                AND i.Infection_Type = 'COVID-19'
                                AND w.End_Date IS NULL 
                                AND e.Role = 'doctor' 
                                AND i.Date >= DATE_SUB(CURRENT_DATE(), INTERVAL 2 WEEK) 
                            ORDER BY w.Facility_Name ASC,
                                     e.First_Name ASC");
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Infected with Covid-19 </title>
</head>
<body>
<h1>List of Doctors Infected with Covid-19 in the Last 2 Weeks</h1>
    <table border='1'>
        <thead>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Infection Date</td>
                <td>Facility_Name</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../../">Back to homepage</a>
</body>
</html>