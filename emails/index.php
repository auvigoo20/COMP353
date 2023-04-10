<?php
session_start();
require_once("../database.php");
$statement = $conn->prepare('select Medicare_Number, Employee_Email, Facility_Name, Subject, Date, Body 
                            from hbc353_4.Email
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
    <h1>Email Log</h1>

    <table border="1">
        <thead >
            <tr>
                <td>Medicare Number</td>
                <td>Facility Name</td>
                <td>Date</td>
                <td>Email</td>
                <td>Subject</td>
                <td>Preview</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Date"] ?></td>
                    <td><?= $row["Employee_Email"] ?></td>
                    <td><?= $row["Subject"] ?></td>
                    <td><?= substr($row["Body"], 0 ,80) ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>

</body>


</html>