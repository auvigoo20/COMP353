<?php require_once '../database.php';

if (isset($_POST["Type"])){

    $newInfection = $conn->prepare(("INSERT INTO hbc353_4.Infections
                                    VALUES (:Type, :Description)"));
    $newInfection->bindParam(':Type', $_POST["Type"]);
    $newInfection->bindParam(':Description', $_POST["Description"]);

    if ($newInfection->execute()) {
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
    <title>Create Infection</title>
</head>
<body>

<h1>Add Infection</h1>

    <form action="./create.php" method="post">
        <label for="Type">Type</label>
        <input type="text" name="Type" id="Type"> <br>

        <label for="Description">Description</label>
        <input type="text" name="Description" id="Description"> <br>

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Infections list</a>
    
</body>
</html>
