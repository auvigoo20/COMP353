<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Infected');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infected Employees</title>
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>List of Infected Employees</h1>
        <a href="./create.php" class="btn btn-primary mb-3">Add a new infected employee record</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Medicare Number</th>
                    <th>Infection Type</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Infection_Type"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>&Infection_Type=<?= $row["Infection_Type"] ?>&Date=<?= $row["Date"] ?>"
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
