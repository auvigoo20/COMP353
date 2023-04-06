<?php require_once '../database.php';
// Get vaccine information from Infections
$statement = $conn->prepare("SELECT * FROM hbc353_4.Infections AS Infections WHERE Infections.Type = :Infection_Type");
$statement->bindParam(':Infection_Type', $_GET["Type"]);
$statement->execute();
$infection = $statement->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infection: <?= $infection["Type"] ?></title>
</head>
<body>
    <h1>Infection Type: <?= $infection["Type"] ?></h1>
    <p>Description: <?= $infection["Description"] ?></p>
    <a href="./">Back to Infections list</a>
</body>
</html>