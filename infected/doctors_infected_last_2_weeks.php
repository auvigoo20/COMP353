<?php require_once '../database.php';
// THIS IS A SAMPLE FILE USED FOR REFERENCE. ACTUAL CODE NEEDS TO BE RE-WRITTEN AND REFACTORED TO SATISFY THE REQUIREMENTS
$statement = $conn->prepare("SELECT E.First_Name,
                                    E.Last_Name,
                                    I.Date AS Date_of_Infection,
                                    W.Facility_Name AS Facility_Name
                            FROM Employees E,  Infected I, Works W, 
                                (SELECT DISTINCT CURDATE() AS today) AS D
                            WHERE E.Medicare_Number = I.Medicare_Number 
                                AND E.Medicare_Number = W.Medicare_Number
                                AND I.Date <=  D.today AND I.Date >= (D.Today - 14) 
                                AND E.Role = 'Doctor'
                                AND W.End_Date IS NULL
                                AND I.Infection_Type = 'COVID-19'
                            ORDER BY W.Facility_Name ASC, E.First_Name ASC;");
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
                <td>Facility Name</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Date_of_Infection"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../../">Back to homepage</a>
</body>
</html>