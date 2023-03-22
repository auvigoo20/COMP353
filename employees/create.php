<?php require_once '../database.php';

if (
    isset($_POST["Medicare_Number"]) &&
    isset($_POST["First_Name"]) &&
    isset($_POST["Last_Name"]) &&
    isset($_POST["Date_Of_Birth"]) &&
    isset($_POST["Telephone_Number"]) &&
    isset($_POST["Address"]) &&
    isset($_POST["City"]) &&
    isset($_POST["Province"]) &&
    isset($_POST["Postal_Code"]) &&
    isset($_POST["Email"]) &&
    isset($_POST["Citizenship"]) &&
    isset($_POST["Role"])
) {
    $employee = $conn->prepare(("INSERT INTO hbc353_4.Employees (Medicare_Number, First_Name, Last_Name, Date_Of_Birth, Telephone_Number, Address, City, Province, Postal_Code, Email, Citizenship, Role)
                                VALUES  (:Medicare_Number, :First_Name, :Last_Name, :Date_Of_Birth, :Telephone_Number, :Address, :City, :Province, :Postal_Code, :Email, :Citizenship, :Role)"));

    $employee->bindParam(':Medicare_Number', $_POST["Medicare_Number"]);
    $employee->bindParam(':First_Name', $_POST["First_Name"]);
    $employee->bindParam(':Last_Name', $_POST["Last_Name"]);
    $employee->bindParam(':Date_Of_Birth', $_POST["Date_Of_Birth"]);
    $employee->bindParam(':Telephone_Number', $_POST["Telephone_Number"]);
    $employee->bindParam(':Address', $_POST["Address"]);
    $employee->bindParam(':City', $_POST["City"]);
    $employee->bindParam(':Province', $_POST["Province"]);
    $employee->bindParam(':Postal_Code', $_POST["Postal_Code"]);
    $employee->bindParam(':Email', $_POST["Email"]);
    $employee->bindParam(':Citizenship', $_POST["Citizenship"]);
    $employee->bindParam(':Role', $_POST["Role"]);

    if ($employee->execute()) {
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

        <label for="Address">Address</label>
        <input type="text" name="Address" id="Address"> <br>

        <label for="City">City</label>
        <input type="text" name="City" id="City"> <br>

        <label for="Province">Province</label>
        <input type="text" name="Province" id="Province"> <br>

        <label for="Postal_Code">Postal Code</label>
        <input type="text" name="Postal_Code" id="Postal_Code"> <br>

        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email"> <br>

        <label for="Citizenship">Citizenship</label>
        <input type="text" name="Citizenship" id="Citizenship"> <br>

        <label for="Role">Role</label>
        <input type="text" name="Role" id="Role"> <br>

        <button type="submit">Add</button>



    </form>
    <a href="./">Back to employee list</a>

</body>

</html>