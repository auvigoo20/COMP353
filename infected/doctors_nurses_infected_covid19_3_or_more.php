<?php require_once '../database.php';
// THIS IS A SAMPLE FILE USED FOR REFERENCE. ACTUAL CODE NEEDS TO BE RE-WRITTEN AND REFACTORED TO SATISFY THE REQUIREMENTS
$statement = $conn->prepare("SELECT E.First_Name, 
                                    E.Last_Name, 
                                    E.Date_Of_Birth, 
                                    E.Email, 
                                    E.Role, 
                                    MIN(W.Start_Date) AS First_Day_of_Work,
                                    COUNT(DISTINCT I.Medicare_Number, I.Infection_Type, I.Date) AS Total_Infections,
                                    (SELECT SUM(TIME_TO_SEC(TIMEDIFF(S.End_Time, S.Start_Time))) / 3600 FROM Scheduled S
                                        WHERE S.Medicare_Number = E.Medicare_Number) AS Total_Hours_Scheduled
                            FROM Employees E
                            JOIN Works W ON E.Medicare_Number = W.Medicare_Number
                            JOIN Infected I ON E.Medicare_Number = I.Medicare_Number
                            LEFT JOIN Scheduled S ON E.Medicare_Number = S.Medicare_Number
                            WHERE I.Infection_Type = 'COVID-19' AND
                                    W.End_Date IS NULL AND
                                    (E.Role = 'doctor' OR E.Role =  'nurse')
                            GROUP BY E.Medicare_Number, E.Role, E.First_Name, E.Last_Name, E.Date_Of_Birth, E.Email
                                HAVING COUNT(DISTINCT I.Medicare_Number, I.Infection_Type, I.Date) >= 3
                            ORDER BY E.Role, E.First_Name, E.Last_Name ASC");
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Infected with Covid-19 at least 3 times</title>
</head>
<body>
<h1>List of Doctors Infected with Covid-19 at least 3 times</h1>
    <table border='1'>
        <thead>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Date of Birth</td>
                <td>Email</td>
                <td>Role</td>
                <td>First Day of Work</td>
                <td>Total Number of Hours Scheduled</td>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <tr>
                    <td><?= $row["First_Name"] ?></td>
                    <td><?= $row["Last_Name"] ?></td>
                    <td><?= $row["Date_Of_Birth"] ?></td>
                    <td><?= $row["Email"] ?></td>
                    <td><?= $row["Role"] ?></td>
                    <td><?= $row["First_Day_of_Work"] ?></td>
                    <td><?= $row["Total_Hours_Scheduled"] ?></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>
</html>