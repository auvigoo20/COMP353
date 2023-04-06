<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM hbc353_4.Employees AS employee WHERE employee.Medicare_Number = :Medicare_Number");
$statement->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch the key of the address from lives
$employeeLives = $conn->prepare("SELECT * from hbc353_4.Lives as Lives Where Lives.Medicare_Number = :Medicare_Number");
$employeeLives->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
$employeeLives->execute();
$lives = $employeeLives->fetch(PDO::FETCH_ASSOC);

// Fetch the employee's current address
$employeeCurrentAddressStatement = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                                    WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
$employeeCurrentAddressStatement->bindParam(':Street_Address', $lives["Street_Address"]);
$employeeCurrentAddressStatement->bindParam(':Postal_Code', $lives["Postal_Code"]);
$employeeCurrentAddressStatement->execute();
$employeeCurrentAddress = $employeeCurrentAddressStatement->fetch(PDO::FETCH_ASSOC);
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
    <p>Street Address: <?= $employeeCurrentAddress["Street_Address"] ?></p>
    <p>City: <?= $employeeCurrentAddress["City"] ?></p>
    <p>Province: <?= $employeeCurrentAddress["Province"] ?></p>
    <p>Postal Code: <?= $employeeCurrentAddress["Postal_Code"] ?></p>
    <p>Email: <?= $employee["Email"] ?></p>
    <p>Citizenship: <?= $employee["Citizenship"] ?></p>
    <p>Role: <?= $employee["Role"] ?></p>

    <a href="./">Back to employeees list</a>
    
</body>
</html>