<?php require_once '../database.php';

// Fetch the Vaccine to be edited
$statement = $conn->prepare("SELECT * FROM hbc353_4.Infections AS Infections WHERE Infections.Type = :Type");

// This check is required because this block of code is run twice (when the page loads for the first time, and after the POST request)
if (isset($_GET["Type"])) {
    $statement->bindParam(':Type', $_GET["Type"]);
} else if (isset($_POST["Type"])) {
    $statement->bindParam(':Type', $_POST["Type"]);
}
$statement->execute();
$editedInfection = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_POST["Type"]) &&
    isset($_POST["Description"])
) {
    // Update the vaccine entry
    $infection = $conn->prepare("UPDATE hbc353_4.Infections 
                                SET Description = :Description
                                WHERE Type = :Type;");
    $infection->bindParam(':Type', $_POST["Type"]);
    $infection->bindParam(':Description', $_POST["Description"]);

    if ($infection->execute()) {
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
    <title>Edit Infection</title>
</head>

<body>
    <h1>Edit Infection</h1>

    <form action="./edit.php" method="post">
        <label for="Type">Type</label>
        <input type="text" name="Type" id="Type" value="<?= $editedInfection["Type"] ?>" readonly> <br>

        <label for="Description">Description</label>
        <input type="text" name="Description" id="Description" value="<?= $editedInfection["Description"] ?>"> <br>
        <button type="submit">Update</button>
    </form>
    <a href="./">Back to infection list</a>


</body>

</html>