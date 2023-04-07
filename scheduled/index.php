<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Scheduled');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Employees</title>
</head>
<body>
<h1>List of Scheduled Employees</h1>
    <a href="./create.php">Add a new Scheduled Employee Record</a>

    <table border='1'>
        <thead>
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Date</td>
                <td>Start Time</td>
                <td>End Time</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Start_Time"] ?></td>
                    <td><?= $row["End_Time"] ?></td>
                    <td>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Date=<?= $row["Date"] ?>&Start_Time=<?= $row["Start_Time"] ?>&End_Time=<?= $row["End_Time"] ?>"><button>Delete</button></a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
    
</body>
</html>