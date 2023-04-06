<?php require_once '../database.php';
// Get vaccine information from Vaccines
$statement = $conn->prepare("SELECT * FROM hbc353_4.Vaccines AS Vaccines WHERE Vaccines.Type = :Vaccine_Type");
$statement->bindParam(':Vaccine_Type', $_GET["Type"]);
$statement->execute();
$vaccine = $statement->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine: <?= $vaccine["Type"] ?></title>
</head>
<body>
    <h1>Vaccine Type: <?= $vaccine["Type"] ?></h1>
    <p>Description: <?= $vaccine["Description"] ?></p>
    <a href="./">Back to Vaccines list</a>
</body>
</html>