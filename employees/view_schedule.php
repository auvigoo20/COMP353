<?php require_once '../database.php';

$statement = $conn->prepare('SELECT Facility_Name, Date, Start_Time, End_Time
                            FROM Scheduled 
                            WHERE Medicare_Number = :Medicare_Number
                            ORDER BY Facility_Name ASC, Date ASC, Start_Time ASC');
$statement->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title><?= $_GET["Medicare_Number"]?>'s Schedule</title>
</head>

<body>
    <h1><?= $_GET["Medicare_Number"]?>'s Schedule</h1>

    <table border="1">
        <thead >
            <tr>
                <td>Facility Name</td>
                <td>Date</td>
                <td>Start Time</td>
                <td>End Time</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Start_Time"] ?></td>
                    <td><?= $row["End_Time"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="././">Back to list of employees</a>

</body>

</html>