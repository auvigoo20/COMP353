<?php 
require_once '../database.php';

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

    // First check if the given address exists
    $existingAddress = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                        WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
    $existingAddress->bindParam(':Street_Address', $_POST["Street_Address"]);
    $existingAddress->bindParam(':Postal_Code', $_POST["Postal_Code"]);
    $existingAddress->execute();
    if ($existingAddress->rowCount() == 0){
        // Need to add new Address entry since the user's address input does not already exist
        $newAddress = $conn->prepare(("INSERT INTO hbc353_4.Address
                                       VALUES (:Street_Address, :Postal_Code, :City, :Province)"));
        $newAddress->bindParam(':Street_Address', $_POST["Street_Address"]);
        $newAddress->bindParam(':Postal_Code', $_POST["Postal_Code"]);                       
        $newAddress->bindParam(':City', $_POST["City"]);                       
        $newAddress->bindParam(':Province', $_POST["Province"]);        
        
        $newAddress->execute();
    }

    // Create new record for Facilities table
    $employee = $conn->prepare(("INSERT INTO hbc353_4.Facilities (Name, Phone_Number, Capacity, Web_Address, Type)
                                VALUES  (:Name, :Phone_Number, :Capacity, :Web_Address, :Type)"));

    $employee->bindParam(':Name', $_POST["Name"]);
    $employee->bindParam(':Phone_Number', $_POST["Phone_Number"]);
    $employee->bindParam(':Capacity', $_POST["Capacity"]);
    $employee->bindParam(':Web_Address', $_POST["Web_Address"]);
    $employee->bindParam(':Type', $_POST["Type"]);

    $employee->execute();


    // Create new record for Located table
    $lives = $conn->prepare(("INSERT INTO hbc353_4.Located(Facility_Name, Street_Address, Postal_Code) 
                                VALUES(:Facility_Name, :Street_Address, :Postal_Code)"));
    $lives->bindParam(':Facility_Name',$_POST["Name"]);
    $lives->bindParam(':Street_Address',$_POST["Street_Address"]);
    $lives->bindParam(':Postal_Code',$_POST["Postal_Code"]);

    if ($lives->execute()) {
        header("Location: .");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Facility</title>
</head>

<body>
    <h1>Add Facility</h1>

    <form action="./create.php" method="post">
        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name"> <br>

        <label for="Phone_Number">Phone Number</label>
        <input type="text" name="Phone_Number" id="Phone_Number"> <br>

        <label for="Capacity">Capacity</label>
        <input type="number" name="Capacity" id="Capacity"> <br>

        <label for="Web_Address">Web Address</label>
        <input type="text" name="Web_Address" id="Web_Address"> <br>

        <label for="Type">Type</label>
        <select name="Type" id="Type"> 
            <option value="">--Please choose an option--</option>
            <option value="Hospital">Hospital</option>
            <option value="CLSC">CLSC</option>
            <option value="Clinic">Clinic</option>
            <option value="Pharmacy">Pharmacy</option>
            <option value="Special Installment">Special Installment</option>
        </select>
        
        <br>

        <label for="Street_Address">Street Address</label>
        <input type="text" name="Street_Address" id="Street_Address"> <br>

        <label for="City">City</label>
        <input type="text" name="City" id="City"> <br>

        <label for="Province">Province</label>
        <select name="Province" id="Province"> 
            <option value="">--Please choose an option--</option>
            <option value="AB">Alberta</option>
            <option value="BC">British Columbia</option>
            <option value="MB">Manitoba</option>
            <option value="NB">New Brunswick</option>
            <option value="NL">Newfoundland and Labrador</option>
            <option value="NT">Northwest Territories</option>
            <option value="NS">Nova Scotia</option>
            <option value="NU">Nunavut</option>
            <option value="ON">Ontario</option>
            <option value="PE">Prince Edward Island</option>
            <option value="QC">Quebec</option>
            <option value="SK">Saskatchewan</option>
            <option value="YT">Yukon</option>
        </select>
        
        <br>

        <label for="Postal_Code">Postal Code</label>
        <input type="text" name="Postal_Code" id="Postal_Code"> <br>

        <button type="submit">Add</button>



    </form>
    <a href="./">Back to employee list</a>

</body>

</html>