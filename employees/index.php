<?php require_once '../database.php';

$statement = $conn->prepare('SELECT Employees.Medicare_Number, First_Name, Last_Name, Date_Of_Birth, Telephone_Number, Email, Citizenship, Role,
                             Address.Street_Address AS Street_Address, 
                             Address.City AS City, 
                             Address.Province AS Province, 
                             Address.Postal_Code AS Postal_Code 
                            FROM hbc353_4.Employees AS Employees, hbc353_4.Lives AS Lives, hbc353_4.Address as Address 
                            WHERE Employees.Medicare_Number = Lives.Medicare_Number and 
                            Lives.Postal_Code = Address.Postal_Code and 
                            Lives.Street_Address = Address.Street_Address');
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title>Employees</title>
</head>

<body>
    <h1>List of Employees</h1>
    <a href="./create.php">Add a new employee</a>

    <table border="1">
        <thead >
            <tr>
                <td>Medicare Number</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Date of Birth</td>
                <td>Telephone Number</td>
                <td>Email</td>
                <td>Citizenship</td>
                <td>Role</td>
                <td>Street Address</td>
                <td>City</td>
                <td>Province</td>
                <td>Postal Code</td>
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
                    <td><?= $row["Email"] ?></td>
                    <td><?= $row["Citizenship"] ?></td>
                    <td><?= $row["Role"] ?></td>
                    <td><?= $row["Street_Address"] ?></td>
                    <td><?= $row["City"] ?></td>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Postal_Code"] ?></td>
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