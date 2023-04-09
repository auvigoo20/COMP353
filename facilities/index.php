<?php require_once '../database.php';

$statement = $conn->prepare('SELECT f.Name,
                                    a.Street_Address,
                                    a.City,
                                    a.Province,
                                    a.Postal_Code,
                                    f.Phone_Number,
                                    f.Web_Address,
                                    f.Type,
                                    f.Capacity,
                                    CONCAT(e.First_Name, " ", e.Last_Name) AS Manager_Name,
                                    COUNT(w.Medicare_Number) AS Number_of_Employees
                                FROM
                                hbc353_4.Facilities AS f
                                LEFT JOIN
                                hbc353_4.Manages AS m ON f.Name = m.Facility_Name
                                LEFT JOIN
                                hbc353_4.Employees AS e ON m.Medicare_Number = e.Medicare_Number
                                LEFT JOIN
                                hbc353_4.Works AS w ON f.Name = w.Facility_Name AND w.End_Date is null
                                LEFT JOIN
                                hbc353_4.Located AS l on f.Name = l.Facility_Name
                                LEFT JOIN
                                hbc353_4.Address AS a on a.Postal_Code = l.Postal_Code and a.Street_Address = l.Street_Address
                                GROUP BY
                                    f.Name,
                                    f.Phone_Number,
                                    f.web_address,
                                    f.Type,
                                    a.Province,
                                    a.City
                                ORDER BY
                                    a.Province ASC,
                                    a.City ASC,
                                    f.Type ASC,
                                    Number_of_Employees ASC');

$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities</title>
</head>

<body>
    <h1>List of Facilities</h1>
    <a href="./create.php">Add a new facility</a>

    <table border="1">
        <thead>
            <tr>
                <td>Name</td>
                <td>Street Address</td>
                <td>City</td>
                <td>Province</td>
                <td>Postal Code</td>
                <td>Phone Number</td>
                <td>Web Address</td>
                <td>Type</td>
                <td>Capacity</td>
                <td>Manager Name</td>
                <td>Number of Employees</td>                
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["Name"] ?></td>
                    <td><?= $row["Street_Address"] ?></td>
                    <td><?= $row["City"] ?></td>
                    <td><?= $row["Province"] ?></td>
                    <td><?= $row["Postal_Code"] ?></td>
                    <td><?= $row["Phone_Number"] ?></td>
                    <td><?= $row["Web_Address"] ?></td>
                    <td><?= $row["Type"] ?></td>
                    <td><?= $row["Capacity"] ?></td>
                    <td><?= $row["Manager_Name"] ?></td>
                    <td><?= $row["Number_of_Employees"] ?></td>
                    <td>
                        <a href="./show.php?Name=<?= $row["Name"] ?>"><button>Show</button></a>
                        <a href="./edit.php?Name=<?= $row["Name"] ?>"><button>Edit</button></a>
                        <a href="./delete.php?Name=<?= $row["Name"] ?>"><button>Delete</button></a>
                        <a href="./facility_employees.php?Name=<?= $row["Name"] ?>"><button>View employees</button></a>
                        <br>
                        <br>
                        <a href="./view_on_schedule_doc_nurses.php?Name=<?= $row["Name"] ?>"><button>View doctors and nurses</button></a>
                        <a href="./view_hours_scheduled_per_role.php?Name=<?= $row["Name"] ?>"><button>View hours per role</button></a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>

</html>