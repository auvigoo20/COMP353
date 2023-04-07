<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Works');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Works</title>
</head>
<body>
<h1>List of Employees' working history</h1>
    <a href="./create.php">Add a new employee work record</a>

    <table border='1'>
        <thead>
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Start Date</td>
                <td>End Date</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Start_Date"] ?></td>
                    <td><?= $row["End_Date"] ?></td>

                    <td>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Start_Date=<?= $row["Start_Date"] ?>"><button>Delete</button></a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
    
</body>
</html>