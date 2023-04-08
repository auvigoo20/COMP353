<?php require_once '../database.php'; 

// Prepare the values to populate the Facilities dropdown
$facilitiesStatement = $conn->prepare("SELECT Name AS Facility_Name FROM hbc353_4.Facilities AS Facilities");
$facilitiesStatement->execute();

// Delete the current schedule of the employee
$statement = $conn->prepare("DELETE FROM hbc353_4.Scheduled
                            WHERE Medicare_Number = :Medicare_Number AND 
                                  Facility_Name = :Facility_Name AND
                                  Date = :Date AND
                                  Start_Time = :Start_Time AND
                                  End_Time = :End_Time;");
$statement->bindParam(":Medicare_Number", $_GET["Medicare_Number"]);
$statement->bindParam(":Facility_Name", $_GET["Facility_Name"]);
$statement->bindParam(":Date", $_GET["Date"]);
$statement->bindParam(":Start_Time", $_GET["Start_Time"]);
$statement->bindParam(":End_Time", $_GET["End_Time"]);
$statement->execute();

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
   $newWorks->bindParam(':End_Time', $_POST['End_Time']);
   
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
    <title>Edit an employee's schedule</title>
</head>

<body>

    <h1>Edit an employee's shift</h1>
    <p><b>You must edit the employee. Otherwise, they may be removed from the system</b></p>

    <form action="./edit.php" method="post">
        <label for="Medicare_Number">Medicare Number</label>
        <input type="text" name="Medicare_Number" id="Medicare_Number" readonly value="<?= $_GET["Medicare_Number"] ?>"></input>

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
        <input type="date" name="Date" id="Date" value="<?= $_GET["Date"] ?>" > <br/>

        <label for="Start_Time">Start Time</label>
        <input type="time" name="Start_Time" id="Start_Time" value="<?= $_GET['Start_Time']?>">
        <br>
        <label for="End_Time">End Time</label>
        <input type="time" name="End_Time" id="End_Time" value="<?= $_GET['End_Time']?>">
        <br>
        <button type="submit">Edit</button>
    </form>

</body>

</html>