<?php require_once '../database.php';

// Prepare the values to populate the dropdowns
$employeesStatement = $conn->prepare("SELECT Medicare_Number FROM hbc353_4.Employees AS Employees");
$employeesStatement->execute();

$facilitiesStatement = $conn->prepare("SELECT Name AS Facility_Name FROM hbc353_4.Facilities AS Facilities");
$facilitiesStatement->execute();

$vaccinesStatement = $conn->prepare("SELECT Type AS Vaccine_Type FROM hbc353_4.Vaccines AS Vaccines");
$vaccinesStatement->execute();


if (
    isset($_POST['Medicare_Number']) &&
    isset($_POST['Facility_Name']) &&
    isset($_POST['Vaccine_Type']) &&
    isset($_POST['Date']) &&
    isset($_POST['Dose'])

) {
    $newWorks = $conn->prepare(("INSERT INTO hbc353_4.Vaccinated VALUES (:Medicare_Number, :Facility_Name, :Vaccine_Type, :Date, :Dose)"));
    $newWorks->bindParam(':Medicare_Number', $_POST['Medicare_Number']);
    $newWorks->bindParam(':Facility_Name', $_POST['Facility_Name']);
    $newWorks->bindParam(':Vaccine_Type', $_POST['Vaccine_Type']);
    $newWorks->bindParam(':Date', $_POST['Date']);
    $newWorks->bindParam(':Dose', $_POST['Dose']);
    if ($newWorks->execute()) {
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
    <title>Add new vaccinated record</title>
</head>

<body>

    <h1>Add new vaccinated record</h1>

    <form action="./create.php" method="post">
        <label for="Medicare_Number">Medicare Number</label>
        <select name="Medicare_Number" id="Medicare_Number">
            <option value="">--Please choose an option--</option>
            <?php while($row = $employeesStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Medicare_Number"];?>">
                    <?php echo $row["Medicare_Number"];?>
                </option>
            <?php } ?>
        </select>

        <br>

        <label for="Facility_Name">Facility Name</label>
        <select name="Facility_Name" id="Facility_Name">
            <option value="">--Please choose an option--</option>
            <?php while($row = $facilitiesStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Facility_Name"];?>">
                    <?php echo $row["Facility_Name"];?>
                </option>
            <?php } ?>
        </select>

        <br/>

        <label for="Vaccine_Type">Vaccine Type</label>
        <select name="Vaccine_Type" id="Vaccine_Type">
            <option value="">--Please choose an option--</option>
            <?php while($row = $vaccinesStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Vaccine_Type"];?>">
                    <?php echo $row["Vaccine_Type"];?>
                </option>
            <?php } ?>
        </select>

        <br/>

        <label for="Date">Date</label>
        <input type="date" name="Date" id="Date"> <br/>

        <label for="Dose">Dose</label>
        <input type="number" name="Dose" id="Dose"> <br/>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Vaccinated list</a>

</body>

</html>