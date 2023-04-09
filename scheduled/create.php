<?php require_once '../database.php';

// Prepare the values to populate the dropdowns
$employeesStatement = $conn->prepare("SELECT Medicare_Number FROM hbc353_4.Employees AS Employees");
$employeesStatement->execute();

$facilitiesStatement = $conn->prepare("SELECT Name AS Facility_Name FROM hbc353_4.Facilities AS Facilities");
$facilitiesStatement->execute();


if (
    isset($_POST['Medicare_Number']) &&
    isset($_POST['Facility_Name']) &&
    isset($_POST['Date']) &&
    isset($_POST['Start_Time']) &&
    isset($_POST['End_Time'])

) {
   // Add a new scheduled record
   $newWorks = $conn->prepare(("INSERT INTO hbc353_4.Scheduled VALUES (:Medicare_Number, :Facility_Name, :Date, :Start_Time, :End_Time)"));
   $newWorks->bindParam(':Medicare_Number', $_POST['Medicare_Number']);
   $newWorks->bindParam(':Facility_Name', $_POST['Facility_Name']);
   $newWorks->bindParam(':Date', $_POST['Date']);
   $newWorks->bindParam(':Start_Time', $_POST['Start_Time']);
   $newWorks->bindParam(':End_Time', $_POST['End_Time']);;
   
   try{
    if ($newWorks->execute()) {
        header("Location: .");
       }
   }
   catch (Exception $e){
    echo '<script>alert("'.$e->getMessage() .'")</script>';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule an employee's shift</title>
</head>

<body>

    <h1>Schedule an employee's shift</h1>

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

        <label for="Date">Date</label>
        <input type="date" name="Date" id="Date"> <br/>

        <label for="Start_Time">Start Time</label>
        <input type="time" name="Start_Time" id="Start_Time">
        <br>

        <label for="End_Time">End Time</label>
        <input type="time" name="End_Time" id="End_Time">
        <br>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Scheduled list</a>

</body>

</html>