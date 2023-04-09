<?php require_once '../database.php';

$statement = $conn->prepare("SELECT a.Province, f.Name AS Facility_Name, f.Capacity,
                                    COUNT(DISTINCT i.Medicare_Number) AS Total_Employees_Infected
                            FROM hbc353_4.Facilities f
                            LEFT JOIN hbc353_4.Works w ON f.Name = w.Facility_Name
                            LEFT JOIN hbc353_4.Infected i ON w.Medicare_Number = i.Medicare_Number
                                    AND i.Infection_Type = 'COVID-19'
                                    AND i.Date >= DATE_SUB(CURRENT_DATE(), INTERVAL 2 WEEK)
                            LEFT JOIN Located l ON f.Name = l.Facility_Name
                            LEFT JOIN Address a ON l.Postal_Code = a.Postal_Code 
                                    AND l.Street_Address = a.Street_Address
                            GROUP BY a.Province, f.Name, f.Capacity
                            ORDER BY a.Province ASC, 
                                    Total_Employees_Infected ASC;");

$statement->execute(); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Facilities having Employees Infected by Covid-19 in the Last 2 Weeks</title>
</head>

<body>
    <h1>List of Facilities having Employees Infected by Covid-19 in the Last 2 Weeks</h1>

    <table border="1">
        <thead>
            <tr>
                <td>Province</td>
                <td>Facility Name</td>
                <td>Capacity</td>
                <td>Number of Employees Infected</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Facility_Name"] ?></td>
                    <td><?= $row["Capacity"] ?></td>
                    <td><?= $row["Total_Employees_Infected"] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>

</html>