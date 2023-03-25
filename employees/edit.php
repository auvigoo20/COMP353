<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM hbc353_4.Employees AS employee WHERE employee.Medicare_Number = :Medicare_Number");

// This check is required because this block of code is run twice (when the page loads for the first time, and after the POST request)
if(isset($_GET["Medicare_Number"])){
    $statement->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
}
else if(isset($_POST["Medicare_Number"])){
    $statement->bindParam(':Medicare_Number', $_POST["Medicare_Number"]);
}
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch the employee's current address to autofill the form
$employeeCurrentAddressStatement = $conn->prepare(("SELECT * FROM hbc353_4.Address AS Address
                                                    WHERE Address.Street_Address = :Street_Address AND Address.Postal_Code = :Postal_Code"));
$employeeCurrentAddressStatement->bindParam(':Street_Address', $employee["Street_Address"]);
$employeeCurrentAddressStatement->bindParam(':Postal_Code', $employee["Postal_Code"]);
$employeeCurrentAddressStatement->execute();
$employeeCurrentAddress = $employeeCurrentAddressStatement->fetch(PDO::FETCH_ASSOC);

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


    $employee = $conn->prepare("UPDATE hbc353_4.Employees 
                                SET Medicare_Number = :Medicare_Number,
                                    First_Name = :First_Name,
                                    Last_Name = :Last_Name,
                                    Date_Of_Birth = :Date_Of_Birth,
                                    Telephone_Number = :Telephone_Number,
                                    Street_Address = :Street_Address,
                                    Postal_Code = :Postal_Code,
                                    Email = :Email,
                                    Citizenship = :Citizenship,
                                    Role = :Role
                                WHERE Medicare_Number = :Medicare_Number;");

    $employee->bindParam(':Medicare_Number', $_POST["Medicare_Number"]);
    $employee->bindParam(':First_Name', $_POST["First_Name"]);
    $employee->bindParam(':Last_Name', $_POST["Last_Name"]);
    $employee->bindParam(':Date_Of_Birth', $_POST["Date_Of_Birth"]);
    $employee->bindParam(':Telephone_Number', $_POST["Telephone_Number"]);
    $employee->bindParam(':Street_Address', $_POST["Street_Address"]);
    $employee->bindParam(':Postal_Code', $_POST["Postal_Code"]);
    $employee->bindParam(':Email', $_POST["Email"]);
    $employee->bindParam(':Citizenship', $_POST["Citizenship"]);
    $employee->bindParam(':Role', $_POST["Role"]);

    if ($employee->execute()) {
        header("Location: .");
    }
    else{
        header("Location: ./edit.php?Medicare_Number=" .$_POST["Medicare_Number"]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit employee</title>
</head>

<body>
    <h1>Edit Employee</h1>

    <form action="./edit.php" method="post">
        <label for="Medicare_Number">Medicare Number</label>
        <input type="text" name="Medicare_Number" id="Medicare_Number" value="<?= $employee["Medicare_Number"] ?>"> <br>

        <label for="First_Name">First Name</label>
        <input type="text" name="First_Name" id="First_Name" value="<?= $employee["First_Name"] ?>"> <br>

        <label for="Last_Name">Last Name</label>
        <input type="text" name="Last_Name" id="Last_Name" value="<?= $employee["Last_Name"] ?>"> <br>

        <label for="Date_Of_Birth">Date of Birth</label>
        <input type="date" name="Date_Of_Birth" id="Date_Of_Birth" value="<?= $employee["Date_Of_Birth"] ?>"> <br>

        <label for="Telephone_Number">Telephone Number</label>
        <input type="text" name="Telephone_Number" id="Telephone_Number" value="<?= $employee["Telephone_Number"] ?>"> <br>

        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email" value="<?= $employee["Email"] ?>"> <br>

        <label for="Citizenship">Citizenship</label>
        <input type="text" name="Citizenship" id="Citizenship" value="<?= $employee["Citizenship"] ?>"> <br>

        <label for="Role">Role</label>
        <select name="Role" id="Role">
            <option value="nurse" <?= $employee["Role"] == 'nurse' ? ' selected="selected"' : '';?>>nurse</option>
            <option value="doctor" <?= $employee["Role"] == 'doctor' ? ' selected="selected"' : '';?>>doctor</option>
            <option value="cashier" <?= $employee["Role"] == 'cashier' ? ' selected="selected"' : '';?>>cashier</option>
            <option value="pharmacist" <?= $employee["Role"] == 'pharmacist' ? ' selected="selected"' : '';?>>pharmacist</option>
            <option value="receptionist" <?= $employee["Role"] == 'receptionist' ? ' selected="selected"' : '';?>>receptionist</option>
            <option value="administrative personnel" <?= $employee["Role"] == 'administrative personnel' ? ' selected="selected"' : '';?>>administrative personnel</option>
            <option value="security personnel" <?= $employee["Role"] == 'security personnel' ? ' selected="selected"' : '';?>>security personnel</option>
            <option value="regular employee" <?= $employee["Role"] == 'regular employee' ? ' selected="selected"' : '';?>>regular employee</option>
        </select>
        
        <br>

        <label for="Street_Address">Street Address</label>
        <input type="text" name="Street_Address" id="Street_Address" value="<?= $employee["Street_Address"] ?>"> <br>

        <label for="City">City</label>
        <input type="text" name="City" id="City" value="<?= $employeeCurrentAddress["City"] ?>"> <br>

        <label for="Province">Province</label>        
        <select name="Province" id="Province"> 
            <option value="AB" <?= $employeeCurrentAddress["Province"]  == 'AB' ? ' selected="selected"' : '';?>>Alberta</option>
            <option value="BC" <?= $employeeCurrentAddress["Province"]  == 'BC' ? ' selected="selected"' : '';?>>British Columbia</option>
            <option value="MB" <?= $employeeCurrentAddress["Province"]  == 'MB' ? ' selected="selected"' : '';?>>Manitoba</option>
            <option value="NB" <?= $employeeCurrentAddress["Province"]  == 'NB' ? ' selected="selected"' : '';?>>New Brunswick</option>
            <option value="NL" <?= $employeeCurrentAddress["Province"]  == 'NL' ? ' selected="selected"' : '';?>>Newfoundland and Labrador</option>
            <option value="NT" <?= $employeeCurrentAddress["Province"]  == 'NT' ? ' selected="selected"' : '';?>>Northwest Territories</option>
            <option value="NS" <?= $employeeCurrentAddress["Province"]  == 'NS' ? ' selected="selected"' : '';?>>Nova Scotia</option>
            <option value="NU" <?= $employeeCurrentAddress["Province"]  == 'NU' ? ' selected="selected"' : '';?>>Nunavut</option>
            <option value="ON" <?= $employeeCurrentAddress["Province"]  == 'ON' ? ' selected="selected"' : '';?>>Ontario</option>
            <option value="PE" <?= $employeeCurrentAddress["Province"]  == 'PE' ? ' selected="selected"' : '';?>>Prince Edward Island</option>
            <option value="QC" <?= $employeeCurrentAddress["Province"]  == 'QC' ? ' selected="selected"' : '';?>>Quebec</option>
            <option value="SK" <?= $employeeCurrentAddress["Province"]  == 'SK' ? ' selected="selected"' : '';?>>Saskatchewan</option>
            <option value="YT" <?= $employeeCurrentAddress["Province"]  == 'YT' ? ' selected="selected"' : '';?>>Yukon</option>
        </select>
        
        <br>

        <label for="Postal_Code">Postal Code</label>
        <input type="text" name="Postal_Code" id="Postal_Code" value="<?= $employee["Postal_Code"] ?>"> <br>

        <button type="submit">Update</button>



    </form>
    <a href="./">Back to employee list</a>

</body>

</html>