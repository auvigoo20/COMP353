<?php require_once '../database.php';

$statement = $conn->prepare("SELECT e.Role, SUM(TIME_TO_SEC(TIMEDIFF(s.End_Time, s.Start_Time))) / 3600 AS Total_Hours
                                FROM Scheduled s
                                JOIN Employees e ON s.Medicare_Number = e.Medicare_Number
                                WHERE s.Facility_Name = :Facility_Name
                                GROUP BY e.Role
                                ORDER BY e.Role ASC;");
$statement->bindParam(':Facility_Name',$_GET['Name']);
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title>Total Hours Scheduled per Role at <?= $_GET["Name"]?> </title>
</head>

<body>
    <h1>Total Hours Scheduled per Role at <?= $_GET["Name"]?></h1>
    <table border="1">
        <thead >
            <tr>
                <td>Role</td>
                <td>Scheduled Hours</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Role"] ?></td>
                    <td><?= $row["Total_Hours"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="././">Back to list of facilities</a>

</body>

</html>