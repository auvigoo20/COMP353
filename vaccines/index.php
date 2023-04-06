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
    <title>Vaccines</title>
</head>
<body>
    <h1>List of Vaccines</h1>
    <a href="./create.php">Add a new vaccine</a>

    <table border='1'>
        <thead>
            <tr>
                <td>Type</td>
                <td>Description</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Type"] ?></td>
                    <td><?= $row["Description"] ?></td>

                    <td>
                        <a href="./show.php?Type=<?= $row["Type"] ?>">Show</a>
                        <a href="./edit.php?Type=<?= $row["Type"] ?>">Edit</a>
                        <a href="./delete.php?Type=<?= $row["Type"] ?>">Delete</a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>
</html>
