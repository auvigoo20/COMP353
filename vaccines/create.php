<?php require_once '../database.php';
if (
    isset($_POST['Type']) &&
    isset($_POST['Description'])
    ) {
    $newVaccine = $conn->prepare(("INSERT INTO hbc353_4.Vaccines VALUES (:Type, :Description)"));
    $newVaccine->bindParam(':Type', $_POST['Type']);
    $newVaccine->bindParam(':Description', $_POST['Description']);
    if ($newVaccine->execute()) {
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
    <title>Create Vaccines</title>
</head>

<body>
    <h1>Add Vaccine</h1>

    <form action="./create.php" method="post">
        <label for="Type">Type</label>
        <input type="text" name="Type" id="Type"> <br>

        <label for="Description">Description</label>
        <input type="text" name="Description" id="Type"> <br>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Vaccines list</a>

</body>

</html>