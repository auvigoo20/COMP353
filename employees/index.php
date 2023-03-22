<?php require_once '../database.php';

$statement = $conn->prepare('SELECT * FROM hbc353_4.Employees AS Employees');
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
</head>

<body>
    <h1>List of Employees</h1>
    <a href="./create.php">Add a new employee</a>

    <table>
        <thead>
            <tr>
                <td>Medicare Number</td>
                <td>First name</td>
                <td>Last name</td>
                <td>Date of birth</td>
                <td>Telephone Number</td>
                <td>Address</td>
                <td>City</td>
                <td>Province</td>
                <td>Postal code</td>
                <td>Email</td>
                <td>Citizenship</td>
                <td>Role</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Date_Of_Birth"] ?></td>
                    <td><?= $row["Telephone_Number"] ?></td>
                    <td><?= $row["Address"] ?></td>
                    <td><?= $row["City"] ?></td>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Postal_Code"] ?></td>
                    <td><?= $row["Email"] ?></td>
                    <td><?= $row["Citizenship"] ?></td>
                    <td><?= $row["Role"] ?></td>
                    <td>
                    <a href="./show.php?Medicare_Number=<?= $row["Medicare_Number"] ?>">Show</a>

                        <a href="./edit.php?Medicare_Number=<?= $row["Medicare_Number"] ?>">Edit</a>
                        <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>">Delete</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>

</html>