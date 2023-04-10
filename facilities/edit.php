<?php require_once '../database.php';

// Fetch the Facility to be edited
$statement = $conn->prepare("SELECT * FROM hbc353_4.Facilities AS Facilities WHERE Facilities.Name = :Name");

// This check is required because this block of code is run twice (when the page loads for the first time, and after the POST request)
if (isset($_GET["Name"])) {
    $statement->bindParam(':Name', $_GET["Name"]);
} else if (isset($_POST["Name"])) {
    $statement->bindParam(':Name', $_POST["Name"]);
}
$statement->execute();
$facility = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch the Facility's current address to autofill the form
$facilityLocatedStatement = $conn->prepare(("SELECT * FROM hbc353_4.Located AS Located
                                            WHERE Located.Facility_Name = :Name"));
$facilityLocatedStatement->bindParam(':Name', $facility["Name"]);
$facilityLocatedStatement->execute();
$facilityLocated = $facilityLocatedStatement->fetch(PDO::FETCH_ASSOC);

$facilityCurrentAddressStatement = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                                    WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
$facilityCurrentAddressStatement->bindParam(':Street_Address', $facilityLocated["Street_Address"]);
$facilityCurrentAddressStatement->bindParam(':Postal_Code', $facilityLocated["Postal_Code"]);
$facilityCurrentAddressStatement->execute();
$facilityCurrentAddress = $facilityCurrentAddressStatement->fetch(PDO::FETCH_ASSOC);

if (
    isset($_POST["Name"]) &&
    isset($_POST["Phone_Number"]) &&
    isset($_POST["Capacity"]) &&
    isset($_POST["Web_Address"]) &&
    isset($_POST["Type"]) &&
    isset($_POST["Street_Address"]) &&
    isset($_POST["City"]) &&
    isset($_POST["Province"]) &&
    isset($_POST["Postal_Code"])
) {

    // Create new Address entry if needed
    // First check if the given address exists
    $existingAddress = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                        WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
    $existingAddress->bindParam(':Street_Address', $_POST["Street_Address"]);
    $existingAddress->bindParam(':Postal_Code', $_POST["Postal_Code"]);
    $existingAddress->execute();
    if ($existingAddress->rowCount() == 0) {
        // Need to add new Address entry since the user's address input does not already exist
        $newAddress = $conn->prepare(("INSERT INTO hbc353_4.Address
                                        VALUES (:Street_Address, :Postal_Code, :City, :Province)"));
        $newAddress->bindParam(':Street_Address', $_POST["Street_Address"]);
        $newAddress->bindParam(':Postal_Code', $_POST["Postal_Code"]);
        $newAddress->bindParam(':City', $_POST["City"]);
        $newAddress->bindParam(':Province', $_POST["Province"]);

        $newAddress->execute();
    } else {
        $updatedAddress = $conn->prepare(("UPDATE hbc353_4.Address AS Address
                                            SET Address.City = :City, Address.Province = :Province 
                                            WHERE Address.Street_Address = :Street_Address AND 
                                            Address.Postal_Code = :Postal_Code"));
        $updatedAddress->bindParam(':Street_Address', $_POST["Street_Address"]);
        $updatedAddress->bindParam(':Postal_Code', $_POST["Postal_Code"]);
        $updatedAddress->bindParam(':City', $_POST["City"]);
        $updatedAddress->bindParam(':Province', $_POST["Province"]);
        $updatedAddress->execute();
    }

    // Update the Located entry
    $lives = $conn->prepare(("UPDATE hbc353_4.Located AS Located
                                SET Located.Street_Address = :Street_Address, Located.Postal_Code = :Postal_Code
                                WHERE Located.Facility_Name = :Name"));
    $lives->bindParam(':Street_Address', $_POST["Street_Address"]);
    $lives->bindParam(':Postal_Code', $_POST["Postal_Code"]);
    $lives->bindParam(':Name', $_POST["Name"]);
    $lives->execute();

    // Update the Facilities entry
    $facility = $conn->prepare("UPDATE hbc353_4.Facilities 
                                SET Name = :Name,
                                    Phone_Number = :Phone_Number,
                                    Capacity = :Capacity,
                                    Web_Address = :Web_Address,
                                    Type = :Type
                                WHERE Name = :Name;");

    $facility->bindParam(':Name', $_POST["Name"]);
    $facility->bindParam(':Phone_Number', $_POST["Phone_Number"]);
    $facility->bindParam(':Capacity', $_POST["Capacity"]);
    $facility->bindParam(':Web_Address', $_POST["Web_Address"]);
    $facility->bindParam(':Type', $_POST["Type"]);

    if ($facility->execute()) {
        header("Location: .");
    } else {
        header("Location: ./edit.php?Name=" . $_POST["Name"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Facility</title>
</head>

<body>
    <h1>Edit Facility</h1>

    <form action="./edit.php" method="post">
        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name" value="<?= $facility["Name"] ?>" readonly> <br>

        <label for="Phone_Number">Phone Number</label>
        <input type="text" name="Phone_Number" id="Phone_Number" value="<?= $facility["Phone_Number"] ?>"> <br>

        <label for="Capacity">Capacity</label>
        <input type="number" name="Capacity" id="Capacity" value="<?= $facility["Capacity"] ?>"> <br>

        <label for="Web_Address">Web Address</label>
        <input type="text" name="Web_Address" id="Web_Address" value="<?= $facility["Web_Address"] ?>"> <br>

        <label for="Type">Type</label>
        <select name="Type" id="Type"> 
            <option value="Hospital" <?= $facility["Type"]  == 'Hospital' ? ' selected="selected"' : ''; ?>>Hospital</option>
            <option value="CLSC" <?= $facility["Type"]  == 'CLSC' ? ' selected="selected"' : ''; ?>>CLSC</option>
            <option value="Clinic" <?= $facility["Type"]  == 'Clinic' ? ' selected="selected"' : ''; ?>>Clinic</option>
            <option value="Pharmacy" <?= $facility["Type"]  == 'Pharmacy' ? ' selected="selected"' : ''; ?>>Pharmacy</option>
            <option value="Special Installment" <?= $facility["Type"]  == 'Special Installment' ? ' selected="selected"' : ''; ?>>Special Installment</option>
        </select>
        
        <br>

        <label for="Street_Address">Street Address</label>
        <input type="text" name="Street_Address" id="Street_Address" value="<?= $facilityCurrentAddress["Street_Address"] ?>"> <br>

        <label for="City">City</label>
        <input type="text" name="City" id="City" value="<?= $facilityCurrentAddress["City"] ?>"> <br>

        <label for="Province">Province</label>
        <select name="Province" id="Province">
            <option value="AB" <?= $facilityCurrentAddress["Province"]  == 'AB' ? ' selected="selected"' : ''; ?>>Alberta</option>
            <option value="BC" <?= $facilityCurrentAddress["Province"]  == 'BC' ? ' selected="selected"' : ''; ?>>British Columbia</option>
            <option value="MB" <?= $facilityCurrentAddress["Province"]  == 'MB' ? ' selected="selected"' : ''; ?>>Manitoba</option>
            <option value="NB" <?= $facilityCurrentAddress["Province"]  == 'NB' ? ' selected="selected"' : ''; ?>>New Brunswick</option>
            <option value="NL" <?= $facilityCurrentAddress["Province"]  == 'NL' ? ' selected="selected"' : ''; ?>>Newfoundland and Labrador</option>
            <option value="NT" <?= $facilityCurrentAddress["Province"]  == 'NT' ? ' selected="selected"' : ''; ?>>Northwest Territories</option>
            <option value="NS" <?= $facilityCurrentAddress["Province"]  == 'NS' ? ' selected="selected"' : ''; ?>>Nova Scotia</option>
            <option value="NU" <?= $facilityCurrentAddress["Province"]  == 'NU' ? ' selected="selected"' : ''; ?>>Nunavut</option>
            <option value="ON" <?= $facilityCurrentAddress["Province"]  == 'ON' ? ' selected="selected"' : ''; ?>>Ontario</option>
            <option value="PE" <?= $facilityCurrentAddress["Province"]  == 'PE' ? ' selected="selected"' : ''; ?>>Prince Edward Island</option>
            <option value="QC" <?= $facilityCurrentAddress["Province"]  == 'QC' ? ' selected="selected"' : ''; ?>>Quebec</option>
            <option value="SK" <?= $facilityCurrentAddress["Province"]  == 'SK' ? ' selected="selected"' : ''; ?>>Saskatchewan</option>
            <option value="YT" <?= $facilityCurrentAddress["Province"]  == 'YT' ? ' selected="selected"' : ''; ?>>Yukon</option>
        </select>

        <br>
        <label for="Postal_Code">Postal Code</label>
        <input type="text" name="Postal_Code" id="Postal_Code" value="<?= $facilityCurrentAddress["Postal_Code"] ?>"> <br>
        <button type="submit">Update</button>

    </form>
    <a href="./">Back to facility list</a>
</body>
</html>