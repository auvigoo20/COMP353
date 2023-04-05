<?php require_once '../database.php';
$statement = $conn->prepare('SELECT Facilities.Name, Phone_Number, Capacity, Web_Address, Type,
                            Address.Street_Address AS Street_Address, 
                             Address.City AS City, 
                             Address.Province AS Province, 
                             Address.Postal_Code AS Postal_Code 
                            FROM hbc353_4.Facilities AS Facilities, hbc353_4.Located AS Located,
                            hbc353_4.Address AS Address
                            WHERE Facilities.Name = Located.Facility_Name AND 
                            Located.Postal_Code = Address.Postal_Code AND
                            Address.Street_Address = Located.Street_Address');
$statement->execute();
?>
<!-- Start of doc -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faiclities</title>
</head>

<body>
    <h1>List of Facilities</h1>
    <a href="./create.php">Add a new Facility</a>

    <table border="1">
        <thead>
            <tr>
                <td>Name</td>
                <td>Phone Number</td>
                <td>Capacity</td>
                <td>Web Address</td>
                <td>Type</td>
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
                    <td><?= $row["Name"] ?></td>
                    <td><?= $row["Phone_Number"] ?></td>
                    <td><?= $row["Capacity"] ?></td>
                    <td><?= $row["Web_Address"] ?></td>
                    <td><?= $row["Type"] ?></td>
                    <td><?= $row["Street_Address"] ?></td>
                    <td><?= $row["City"] ?></td>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Postal_Code"] ?></td>
                    <td>
                        <a href="./show.php?Name=<?= $row["Name"] ?>">Show</a>
                        <a href="./edit.php?Name=<?= $row["Name"] ?>">Edit</a>
                        <a href="./delete.php?Name=<?= $row["Name"] ?>">Delete</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</body>

</html>