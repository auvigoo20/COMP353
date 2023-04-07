<?php require_once '../database.php';

// Prepare the values to populate the dropdowns
$employeesStatement = $conn->prepare("SELECT Medicare_Number FROM hbc353_4.Employees AS Employees");
$employeesStatement->execute();

$facilitiesStatement = $conn->prepare("SELECT Name AS Facility_Name FROM hbc353_4.Facilities AS Facilities");
$facilitiesStatement->execute();


if (
    isset($_POST['Medicare_Number']) &&
    isset($_POST['Facility_Name']) &&
    isset($_POST['Start_Date']) &&
    isset($_POST['End_Date'])
) {
    // Fetch the current facility
    $currentFacilityStatement = $conn->prepare("SELECT * FROM hbc353_4.Facilities AS Facilities WHERE Facilities.Name = :Facility_Name");
    $currentFacilityStatement->bindParam(':Facility_Name', $_POST['Facility_Name']);
    $currentFacilityStatement->execute();
    $currentFacility = $currentFacilityStatement->fetch(PDO::FETCH_ASSOC);
    $capacity = $currentFacility['Capacity'];

    // Fetch the current number of employees working in the selected facility
    $worksStatement = $conn->prepare("SELECT COUNT(Medicare_Number) AS 'numOfEmployees'
                                      FROM hbc353_4.Works
                                      WHERE Facility_Name = :Facility_Name AND End_Date IS NULL
                                      GROUP BY Facility_Name");
    $worksStatement->bindParam(':Facility_Name', $_POST['Facility_Name']);
    $worksStatement->execute();
    $works = $worksStatement->fetch(PDO::FETCH_ASSOC);
    $numOfEmployees = $works['numOfEmployees'];

    // check to see if maximum facility capacity has been reached
    if($capacity <$numOfEmployees ){
        // Add a new works record
        $newWorks = $conn->prepare(("INSERT INTO hbc353_4.Works VALUES (:Medicare_Number, :Facility_Name, :Start_Date, :End_Date)"));
        $newWorks->bindParam(':Medicare_Number', $_POST['Medicare_Number']);
        $newWorks->bindParam(':Facility_Name', $_POST['Facility_Name']);
        $newWorks->bindParam(':Start_Date', $_POST['Start_Date']);
        if($_POST['End_Date'] == ''){
            $_POST['End_Date'] = null;
        }
        $newWorks->bindParam(':End_Date', $_POST['End_Date']);
        if ($newWorks->execute()) {
        header("Location: .");
        }
    }else{
        echo '<script>alert("Capacity is reached")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new work record</title>
</head>

<body>

    <h1>Add new employee work record</h1>

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

        <label for="Start_Date">Start Date</label>
        <input type="date" name="Start_Date" id="Start_Date"> <br/>

        <label for="End_Date">End Date</label>
        <input type="date" name="End_Date" id="End_Date">
        
        
        <br>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Vaccines list</a>

</body>

</html>