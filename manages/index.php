<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Manages');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manages</title>
</head>
<body>
<h1>List of Managers of Facilities</h1>
    <a href="./create.php">Add a new Manager to a Facility</a>

    <table border='1'>
        <thead>
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>"><button>Delete</button></a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
    
</body>
</html>