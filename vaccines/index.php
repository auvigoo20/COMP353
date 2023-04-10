<?php require_once '../database.php';
$statement = $conn->prepare('SELECT * FROM Vaccines');
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Vaccines</title>
</head>

<body>
    <div class="container mt-5">
        <h1>List of Vaccines</h1>
        <a href="./create.php" class="btn btn-primary mb-3">Add a new vaccine</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Type"] ?></td>
                    <td><?= $row["Description"] ?></td>

                    <td>
                        <a href="./show.php?Type=<?= $row["Type"] ?>" class="btn btn-info btn-sm">Show</a>
                        <a href="./edit.php?Type=<?= $row["Type"] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="./delete.php?Type=<?= $row["Type"] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../" class="btn btn-secondary">Back to homepage</a>
    </div>
</body>

</html>
