<?php require_once '../database.php';

$statement = $conn->prepare("SELECT e.First_Name,  
                                    e.Last_Name, 
                                    a.City AS City_Of_Residence, 
                                    COUNT(w.Facility_Name) AS Total_Num_Facilities
                                FROM Employees e
                                JOIN Lives l ON e.Medicare_Number = l.Medicare_Number
                                JOIN Address a ON l.Street_Address = a.Street_Address AND l.Postal_Code = a.Postal_Code
                                JOIN Works w ON e.Medicare_Number = w.Medicare_Number
                                JOIN Facilities f ON w.Facility_Name = f.Name
                                WHERE e.Role = 'doctor' AND a.Province = 'QC' 
                                                        AND w.End_Date IS NULL
                                GROUP BY e.Medicare_Number, e.First_Name, e.Last_Name, a.City
                                HAVING COUNT(w.Facility_Name) > 0
                                ORDER BY City_Of_Residence ASC, 
                                         Total_Num_Facilities DESC;");
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" rel="stylesheet" media="screen">
    <title>Doctors Working in the Province of Quebec</title>
</head>

<body>
    <h1>Doctors Working in Facilities Located in the Province of Quebec (Q14)</h1>
    <table border="1">
        <thead >
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>City of Residence</td>
                <td>Total Number of Worked Facilities</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["City_Of_Residence"] ?></td>
                    <td><?= $row["Total_Num_Facilities"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>

</body>

</html>