<?php require_once '../database.php';
// THIS IS A SAMPLE FILE USED FOR REFERENCE. ACTUAL CODE NEEDS TO BE RE-WRITTEN AND REFACTORED TO SATISFY THE REQUIREMENTS
$statement = $conn->prepare("SELECT E.First_Name, 
                                    E.Last_Name, 
                                    MIN(W.Start_Date) AS First_Day_of_Work,
                                    E.Date_Of_Birth, 
                                    E.Email,
                                    SUM(TIMESTAMPDIFF(HOUR, S.Start_Time, S.End_Time)) AS Total_Hours_Scheduled
                            FROM Employees E
                            JOIN Works W ON E.Medicare_Number = W.Medicare_Number
                            JOIN Scheduled S ON E.Medicare_Number = S.Medicare_Number
                            WHERE W.End_Date IS NULL AND
                                    E.Role = 'nurse'
                            GROUP BY E.Medicare_Number, E.Role, E.First_Name, E.Last_Name, E.Date_Of_Birth, E.Email
                            HAVING SUM(TIMESTAMPDIFF(HOUR, S.Start_Time, S.End_Time)) = (
                                        SELECT SUM(TIMESTAMPDIFF(HOUR, S2.Start_Time, S2.End_Time))
                                        FROM Employees E2
                                        JOIN Works W2 ON E2.Medicare_Number = W2.Medicare_Number
                                        JOIN Scheduled S2 ON E2.Medicare_Number = S2.Medicare_Number
                                        WHERE W2.End_Date IS NULL AND
                                                E2.Role = 'nurse'
                                        GROUP BY E2.Medicare_Number, E2.Role
                                        ORDER BY SUM(TIMESTAMPDIFF(HOUR, S2.Start_Time, S2.End_Time)) DESC
                                        LIMIT 1)
                            ORDER BY E.Role ASC, E.First_Name ASC, E.Last_Name ASC;");
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Highest Scheduled working Nurse</title>
</head>
<body>
<h1>Nurse(s) who is/are currently working with the highest number of hours scheduled</h1>
    <table border='1'>
        <thead>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Date of Birth</td>
                <td>Email</td>
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
                    <td><?= $row["First_Day_of_Work"] ?></td>
                    <td><?= $row["Total_Hours_Scheduled"] ?></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="../">Back to homepage</a>
</body>
</html>