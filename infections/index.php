<?php require_once '../database.php';

$statement = $conn->prepare('SELECT * FROM hbc353_4.Infections ');
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
    <title>Infections</title>
</head>
<body>

<div class="container mt-5">
    <h1>List of Infections</h1>
    <a class="btn btn-primary" href="./create.php">Add a new infection</a>

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Type"] ?></td>
                    <td><?= $row["Description"] ?></td>
                    <td>
                        <a class="btn btn-primary" href="./show.php?Type=<?= $row["Type"] ?>">Show</a>
                        <a class="btn btn-secondary" href="./edit.php?Type=<?= $row["Type"] ?>">Edit</a>
                        <a class="btn btn-danger" href="./delete.php?Type=<?= $row["Type"] ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../" class="btn btn-link">Back to homepage</a>
</div>

<!-- Bootstrap JS file (optional) -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
