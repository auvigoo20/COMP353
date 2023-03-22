<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM hbc353_4.Employees AS employee WHERE employee.Medicare_Number = :Medicare_Number");
$statement->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee: <?= $employee["Medicare_Number"] ?></title>
</head>
<body>
    <h1>Employee: <?= $employee["Medicare_Number"] ?></h1>
    <p>First Name: <?= $employee["First_Name"] ?></p>
    <p>Lase Name: <?= $employee["Last_Name"] ?></p>
    <p>Date of birth: <?= $employee["Date_Of_Birth"] ?></p>
    <p>Telephone number: <?= $employee["Telephone_Number"] ?></p>
    <p>Address: <?= $employee["Address"] ?></p>
    <p>City: <?= $employee["City"] ?></p>
    <p>Province: <?= $employee["Province"] ?></p>
    <p>Postal Code: <?= $employee["Postal_Code"] ?></p>
    <p>Email: <?= $employee["Email"] ?></p>
    <p>Citizenship: <?= $employee["Citizenship"] ?></p>
    <p>Role: <?= $employee["Role"] ?></p>
    
</body>
</html>