<?php require_once '../database.php';
// Get facility information from Facilities
$statement = $conn->prepare("SELECT * FROM hbc353_4.Facilities AS Facilities WHERE Facilities.Name = :Facility_Name");
$statement->bindParam(':Facility_Name', $_GET["Name"]);
$statement->execute();
$facility = $statement->fetch(PDO::FETCH_ASSOC);

// Get the location keys
$statement2 = $conn->prepare('SELECT * FROM hbc353_4.Located AS Located WHERE Located.Facility_Name = :Facility_Name');
$statement2 ->bindParam(':Facility_Name',$_GET['Name']);
$statement2->execute();
$located =$statement2->fetch(PDO::FETCH_ASSOC);

// Fetch the Facility's current address
$facilityCurrentAddressStatement = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                                    WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
$facilityCurrentAddressStatement->bindParam(':Street_Address', $located["Street_Address"]);
$facilityCurrentAddressStatement->bindParam(':Postal_Code', $located["Postal_Code"]);
$facilityCurrentAddressStatement->execute();
$facilityCurrentAddress = $facilityCurrentAddressStatement->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility: <?= $facility["Name"] ?></title>
</head>
<body>
    <h1>Facility: <?= $facility["Name"] ?></h1>
    <p>Telephone number: <?= $facility["Phone_Number"] ?></p>
    <p>Web Address: <?= $facility["Web_Address"] ?></p>
    <p>Capacity: <?= $facility["Capacity"] ?></p>
    <p>Type: <?= $facility["Type"] ?></p>
    <p>Street Address: <?= $facilityCurrentAddress["Street_Address"] ?></p>
    <p>City: <?= $facilityCurrentAddress["City"] ?></p>
    <p>Postal Code: <?= $facilityCurrentAddress["Postal_Code"] ?></p>
    <p>Province: <?= $facilityCurrentAddress["Province"] ?></p>
</body>
</html>