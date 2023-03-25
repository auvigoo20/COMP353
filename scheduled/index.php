<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Scheduled
                             ORDER BY Medicare_Number ASC, Date ASC, Start_Time ASC');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Employees</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    

</head>
<body>
<div class="container mt-5">
    <h1>List of Scheduled Employees</h1>
    <a href="./create.php" class="btn btn-primary">Add a new Scheduled Employee Record</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Medicare Number</th>
                <th>Facility Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
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
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Date=<?= $row["Date"] ?>&Start_Time=<?= $row["Start_Time"] ?>&End_Time=<?= $row["End_Time"] ?>" class="btn btn-danger">Delete</a>
                        <a href="./edit.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Date=<?= $row["Date"] ?>&Start_Time=<?= $row["Start_Time"] ?>&End_Time=<?= $row["End_Time"] ?>" class="btn btn-info">Edit</a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../" class="btn btn-secondary">Back to homepage</a>
</div>
    
</body>
</html>
