<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Vaccinated');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccinated Employees</title>
</head>
<body>
<h1>List of Vaccinated Employees</h1>
    <a href="./create.php">Add a new vaccinated employee record</a>

    <table border='1'>
        <thead>
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Vaccine Type</td>
                <td>Date</td>
                <td>Dose</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Vaccine_Type"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Dose"] ?></td>
                    <td>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Vaccine_Type=<?= $row["Vaccine_Type"] ?>&Date=<?= $row["Date"] ?>&Dose=<?= $row["Dose"] ?>"><button>Delete</button></a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
    
</body>
</html>