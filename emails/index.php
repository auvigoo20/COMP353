<?php
session_start();
require_once("../database.php");
<<<<<<< Updated upstream
$statement = $conn->prepare('SELECT Medicare_Number, Facility_Name, Date, Body, 
                            FROM hbc353_4.Email AS Email,
=======
$statement = $conn->prepare('select Medicare_Number, Employee_Email, Facility_Name, Subject, Date, Body 
                            from hbc353_4.Email
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
    <h1>List of Employees</h1>
    <a href="./compose.php">Compose an Email</a>
=======
    <h1>Email Log</h1>
>>>>>>> Stashed changes

    <table border="1">
        <thead >
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Date</td>
<<<<<<< Updated upstream
                <td>Facility Name</td>
=======
                <td>Email</td>
                <td>Subject</td>
                <td>Preview</td>
>>>>>>> Stashed changes
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
<<<<<<< Updated upstream
                    <td><?= $row["Body"] ?></td>
=======
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Employee_Email"] ?></td>
                    <td><?= $row["Subject"] ?></td>
                    <td><?= substr($row["Body"], 0 ,80) ?></td>
>>>>>>> Stashed changes
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>

</body>


</html>