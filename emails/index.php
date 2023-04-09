<?php
session_start();
require_once("../database.php");
$statement = $conn->prepare('SELECT Medicare_Number, Facility_Name, Date, Body, 
                            FROM hbc353_4.Email AS Email,
                            ');
$statement->execute();

?>
<!DOCTYPE html>
<html lang ="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title>Email</title>
</head>

<body>
    <h1>List of Employees</h1>
    <a href="./compose.php">Compose an Email</a>

    <table border="1">
        <thead >
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Date</td>
                <td>Facility Name</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Body"] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>

</body>


</html>