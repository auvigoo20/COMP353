<?php 
require_once '../database.php';

if (
    isset($_POST["Medicare_Number"]) &&
    isset($_POST["First_Name"]) &&
    isset($_POST["Last_Name"]) &&
    isset($_POST["Date_Of_Birth"]) &&
    isset($_POST["Telephone_Number"]) &&
    isset($_POST["Street_Address"]) &&
    isset($_POST["City"]) &&
    isset($_POST["Province"]) &&
    isset($_POST["Postal_Code"]) &&
    isset($_POST["Email"]) &&
    isset($_POST["Citizenship"]) &&
    isset($_POST["Role"])
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

    $employee = $conn->prepare(("INSERT INTO hbc353_4.Employees (Medicare_Number, First_Name, Last_Name, Date_Of_Birth, Telephone_Number, Email, Citizenship, Role)
                                VALUES  (:Medicare_Number, :First_Name, :Last_Name, :Date_Of_Birth, :Telephone_Number, :Email, :Citizenship, :Role)"));

    $employee->bindParam(':Medicare_Number', $_POST["Medicare_Number"]);
    $employee->bindParam(':First_Name', $_POST["First_Name"]);
    $employee->bindParam(':Last_Name', $_POST["Last_Name"]);
    $employee->bindParam(':Date_Of_Birth', $_POST["Date_Of_Birth"]);
    $employee->bindParam(':Telephone_Number', $_POST["Telephone_Number"]);
    $employee->bindParam(':Email', $_POST["Email"]);
    $employee->bindParam(':Citizenship', $_POST["Citizenship"]);
    $employee->bindParam(':Role', $_POST["Role"]);

    $employee->execute();


    // Create new record for Lives table
    $lives = $conn->prepare(("INSERT INTO hbc353_4.Lives(Medicare_Number, Street_Address, Postal_Code) 
                                VALUES(:Medicare_Number, :Street_Address, :Postal_Code)"));
    $lives->bindParam(':Medicare_Number',$_POST["Medicare_Number"]);
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
    <title>Create employee</title>
</head>

<body>
    <h1>Add Employee</h1>

    <form action="./create.php" method="post">
        <label for="Medicare_Number">Medicare Number</label>
        <input type="text" name="Medicare_Number" id="Medicare_Number"> <br>

        <label for="First_Name">First Name</label>
        <input type="text" name="First_Name" id="First_Name"> <br>

        <label for="Last_Name">Last Name</label>
        <input type="text" name="Last_Name" id="Last_Name"> <br>

        <label for="Date_Of_Birth">Date of Birth</label>
        <input type="date" name="Date_Of_Birth" id="Date_Of_Birth"> <br>

        <label for="Telephone_Number">Telephone Number</label>
        <input type="number" name="Telephone_Number" id="Telephone_Number"> <br>

        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email"> <br>

        <label for="Citizenship">Citizenship</label>
        <input type="text" name="Citizenship" id="Citizenship"> <br>

        <label for="Role">Role</label>
        <select name="Role" id="Role">
            <option value="">--Please choose an option--</option>
            <option value="nurse">nurse</option>
            <option value="doctor">doctor</option>
            <option value="cashier">cashier</option>
            <option value="pharmacist">pharmacist</option>
            <option value="receptionist">receptionist</option>
            <option value="administrative personnel">administrative personnel</option>
            <option value="security personnel">security personnel</option>
            <option value="regular employee">regular employee</option>
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