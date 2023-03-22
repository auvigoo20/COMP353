<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM hbc353_4.Employees AS employee WHERE employee.Medicare_Number = :Medicare_Number");
$statement->bindParam(':Medicare_Number', $_GET["Medicare_Number"]);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);


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
    $employee = $conn->prepare("UPDATE hbc353_4.Employees 
                                SET Medicare_Number = :Medicare_Number,
                                    First_Name = :First_Name,
                                    Last_Name = :Last_Name,
                                    Date_Of_Birth = :Date_Of_Birth,
                                    Telephone_Number = :Telephone_Number,
                                    Address = :Address,
                                    City = :City,
                                    Province = :Province,
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

        <label for="Address">Address</label>
        <input type="text" name="Address" id="Address" value="<?= $employee["Address"] ?>"> <br>

        <label for="City">City</label>
        <input type="text" name="City" id="City" value="<?= $employee["City"] ?>"> <br>

        <label for="Province">Province</label>
        <input type="text" name="Province" id="Province" value="<?= $employee["Province"] ?>"> <br>

        <label for="Postal_Code">Postal Code</label>
        <input type="text" name="Postal_Code" id="Postal_Code" value="<?= $employee["Postal_Code"] ?>"> <br>

        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email" value="<?= $employee["Email"] ?>"> <br>

        <label for="Citizenship">Citizenship</label>
        <input type="text" name="Citizenship" id="Citizenship" value="<?= $employee["Citizenship"] ?>"> <br>

        <label for="Role">Role</label>
        <input type="text" name="Role" id="Role" value="<?= $employee["Role"] ?>"> <br>

        <button type="submit">Update</button>



    </form>
    <a href="./">Back to employee list</a>

</body>

</html>