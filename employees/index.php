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
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Employees</title>
</head>

<body>
<div style="margin-left:5px">
        <h1 class="mb-3">List of Employees</h1>
        <a href="./create.php" class="btn btn-primary mb-3">Add a new employee</a>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Medicare Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Telephone Number</th>
                    <th>Email</th>
                    <th>Citizenship</th>
                    <th>Role</th>
                    <th>Street Address</th>
                    <th>City</th>
                    <th>Province</th>
                    <th>Postal Code</th>
                    <th>Actions</th>
                    <th>Schedules</th>
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
                            <a href="./show.php?Medicare_Number=<?= $row["Medicare_Number"] ?>" class="btn btn-info btn-sm">Show</a>
                            <a href="./edit.php?Medicare_Number=<?= $row["Medicare_Number"] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="./delete.php?Medicare_Number=<?= $row["Medicare_Number"] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                        <td>
                            <a href="./view_schedule.php?Medicare_Number=<?= $row["Medicare_Number"] ?>" class="btn btn-success btn-sm">View</a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
        <a href="../" class="btn btn-secondary">Back to homepage</a>
    </div>
    <!-- Bootstrap JS file (optional) -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

</body>

</html>