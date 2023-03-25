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
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>List of Employees' working history</h1>
        <a href="./create.php" class="btn btn-primary mb-3">Add a new employee work record</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Medicare Number</th>
                    <th>Facility Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
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
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Facility_Name=<?= $row["Facility_Name"] ?>&Start_Date=<?= $row["Start_Date"] ?>"
                            class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../" class="btn btn-secondary">Back to homepage</a>
    </div>
</body>

</html>
