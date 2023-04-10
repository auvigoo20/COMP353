<?php require_once '../database.php';

$statement = $conn->prepare("SELECT First_Name, Last_Name, Role
                             FROM Scheduled, Employees
                             WHERE Scheduled.Medicare_Number = Employees.Medicare_Number AND
                                    Scheduled.Facility_Name = :Facility_Name AND
                                    (Employees.Role = 'doctor' OR Employees.Role = 'nurse') AND
                                    Scheduled.Date <= CURDATE() AND
                                    Scheduled.Date > DATE_SUB(CURDATE(), INTERVAL 2 WEEK)
                            ORDER BY Role, First_Name ASC;");
$statement->bindParam(':Facility_Name',$_GET['Name']);
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title><?= $_GET["Name"]?>'s scheduled doctors and nurses</title>
</head>

<body>
    <h1><?= $_GET["Name"]?></h1>
    <h2>List of Scheduled Doctors and Nurses in the Last 2 Weeks</h2>
    <table border="1">
        <thead >
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Role</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Role"] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="././">Back to list of facilities</a>

</body>

</html>