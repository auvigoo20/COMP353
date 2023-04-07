<?php require_once '../database.php';

// Prepare the values to populate the dropdowns
$employeesStatement = $conn->prepare("SELECT Medicare_Number FROM hbc353_4.Employees AS Employees");
$employeesStatement->execute();

$infectionsStatement = $conn->prepare("SELECT Type AS Infection_Type FROM hbc353_4.Infections AS Infections");
$infectionsStatement->execute();


if (
    isset($_POST['Medicare_Number']) &&
    isset($_POST['Infection_Type']) &&
    isset($_POST['Date'])
) {
    $newWorks = $conn->prepare(("INSERT INTO hbc353_4.Infected VALUES (:Medicare_Number, :Infection_Type, :Date)"));
    $newWorks->bindParam(':Medicare_Number', $_POST['Medicare_Number']);
    $newWorks->bindParam(':Infection_Type', $_POST['Infection_Type']);
    $newWorks->bindParam(':Date', $_POST['Date']);
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
    <title>Add new infected record</title>
</head>

<body>

    <h1>Add new infected record</h1>

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

        <label for="Infection_Type">Infection Type</label>
        <select name="Infection_Type" id="Infection_Type">
            <option value="">--Please choose an option--</option>
            <?php while($row = $infectionsStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Infection_Type"];?>">
                    <?php echo $row["Infection_Type"];?>
                </option>
            <?php } ?>
        </select>

        <br/>

        <label for="Date">Date</label>
        <input type="date" name="Date" id="Date"> <br/>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Infected list</a>

</body>

</html>