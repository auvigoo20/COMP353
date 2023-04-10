<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM Email
                             ORDER BY Date ASC;");
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title>All emails sent</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>

<body>
    <div class="container mt-5">
        <h1>All emails sent</h1>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Medicare Number</th>
                    <th>Employee email</th>
                    <th>Facility Name</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                    <tr>
                        <td><?= $row["Medicare_Number"] ?></td>
                        <td><?= $row["Employee_Email"] ?></td>
                        <td><?= $row["Facility_Name"] ?></td>
                        <td><?= $row["Subject"] ?></td>
                        <td><?= $row["Body"] ?></td>
                        <td><?= $row["Date"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../" class="btn btn-primary mt-3">Back to homepage</a>
    </div>

</body>

</html>
