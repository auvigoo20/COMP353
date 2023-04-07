<?php require_once '../database.php';

$statement = $conn->prepare('SELECT Employees.First_Name, 
                                    Employees.Last_Name, 
                                    Works.Start_Date, 
                                    Employees.Date_Of_Birth, 
                                    Employees.Medicare_Number, 
                                    Employees.Telephone_Number, 
                                    Address.Street_Address,
                                    Address.City, 
                                    Address.Province, 
                                    Address.Postal_Code, 
                                    Employees.Citizenship, 
                                    Employees.Email
                            FROM hbc353_4.Employees AS Employees, hbc353_4.Works as Works, hbc353_4.Lives AS Lives, hbc353_4.Address AS Address
                            WHERE Works.Facility_Name = :currentFacility AND Works.End_Date IS NULL AND Employees.Medicare_Number = Works.Medicare_Number AND
                                    Lives.Medicare_Number = Employees.Medicare_Number AND Lives.Street_Address = Address.Street_Address AND Lives.Postal_Code =Address.Postal_Code
                            ORDER BY Employees.Role ASC,
                                     Employees.First_Name ASC,
                                     Employees.Last_Name ASC');
$statement->bindParam(':currentFacility', $_GET["Name"]);
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title><?= $_GET["Name"]?> Employees</title>
</head>

<body>
    <h1><?= $_GET["Name"]?> Employees</h1>

    <table border="1">
        <thead >
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Start Date</td>
                <td>Date of Birth</td>
                <td>Medicare Number</td>
                <td>Telephone Number</td>
                <td>Street Address</td>
                <td>City</td>
                <td>Province</td>
                <td>Postal Code</td>
                <td>Citizenship</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Start_Date"] ?></td>
                    <td><?= $row["Date_Of_Birth"] ?></td>
                    <td><?= $row["Medicare_Number"] ?></td>
                    <td><?= $row["Telephone_Number"] ?></td>
                    <td><?= $row["Street_Address"] ?></td>
                    <td><?= $row["City"] ?></td>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Postal_Code"] ?></td>
                    <td><?= $row["Citizenship"] ?></td>
                    <td><?= $row["Email"] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="././">Back to list of facilities</a>

</body>

</html>