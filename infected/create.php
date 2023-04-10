<?php require_once '../database.php';

// Prepare the values to populate the dropdowns
$employeesStatement = $conn->prepare("SELECT Medicare_Number FROM hbc353_4.Employees AS Employees");
$employeesStatement->execute();

$infectionsStatement = $conn->prepare("SELECT Type AS Infection_Type FROM hbc353_4.Infections AS Infections");
$infectionsStatement->execute();


if (
    isset($_POST['Medicare_Number']) &&
    isset($_POST['Infection_Type']) &&
    isset($_POST['Date'])
) {
    $newWorks = $conn->prepare(("INSERT INTO hbc353_4.Infected VALUES (:Medicare_Number, :Infection_Type, :Date)"));
    $newWorks->bindParam(':Medicare_Number', $_POST['Medicare_Number']);
    $newWorks->bindParam(':Infection_Type', $_POST['Infection_Type']);
    $newWorks->bindParam(':Date', $_POST['Date']);
    if ($newWorks->execute()) {
        header("Location: .");
    }

    // ADD THE EMAIL FUNCTIONALITY HERE.
    /**The system should send an email to inform/track all the doctors and
        nurses who have been in contact by having the same schedule as the infected employee.
        Each email should have as a subject “Warning” and as a body “One of your colleagues
        that you have worked with in the past two weeks have been infected with COVID-19”. */

    if ($_POST['Infection_Type'] == "COVID-19") {

        $date2WeeksAgo = new DateTime($_POST['Date']);

        // Subtract 2 weeks from the date
        $date2WeeksAgo->sub(new DateInterval('P2W'));

        $resultDate = $date2WeeksAgo->format('Y-m-d');

        // Fetch all facilities where the infected employee has been scheduled to work
        $stmt = $conn->prepare("SELECT DISTINCT Facility_Name 
                                  FROM Scheduled 
                                  WHERE Medicare_Number = :infectedMedicareNumber AND
                                        Date BETWEEN :infectedDate2WeeksAgo AND :infectedDate");
        $stmt->bindParam(":infectedMedicareNumber", $_POST['Medicare_Number']);
        $stmt->bindParam(":infectedDate2WeeksAgo", $resultDate);
        $stmt->bindParam(":infectedDate", $_POST['Date']);
        $stmt->execute();
        $facilityNames = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $facilityNames[] = $row['Facility_Name'];
        }


        // Email subject and body text
        $subject = "Warning";
        $body = "One of your colleagues that you have worked with in the past two weeks have been infected with COVID-19";

        $employeesEmails = array();
        $employeesMedicareNumbers = array();
        foreach ($facilityNames as $facilityName) {

            // Fetch the employees that work within the same schedule as the infected employee
            $statement = $conn->prepare("SELECT DISTINCT e.Email, e.Medicare_Number
                                            FROM Scheduled se
                                            JOIN Scheduled se2 ON se.Date = se2.Date AND se.Start_Time <= se2.End_Time AND se.End_Time >= se2.Start_Time
                                            JOIN Employees e ON e.Medicare_Number = se.Medicare_Number
                                                WHERE se2.Medicare_Number = :infectedMedicareNumber AND
                                                      se.Medicare_Number != :infectedMedicareNumber AND
                                                      se.Facility_Name = :Facility_Name AND
                                                      se2.Facility_Name = :Facility_Name;
                                            ");
            $statement->bindParam(':Facility_Name', $facilityName);
            $statement->bindParam(":infectedMedicareNumber", $_POST['Medicare_Number']);
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $employeesEmails[] = $row['Email'];
                $employeesMedicareNumbers[] = $row['Medicare_Number'];
            }

            // Log the sent emails
            for ($x = 0; $x < count($employeesEmails); $x++) {
                $emailStatement = $conn->prepare("INSERT INTO Email 
                                                  VALUES (:Medicare_Number, :Employee_Email, :Facility_Name, :Subject, :Body, :Date)");
                $emailStatement->bindValue(":Medicare_Number", $employeesMedicareNumbers[$x]);
                $emailStatement->bindValue(":Employee_Email", $employeesEmails[$x]);
                $emailStatement->bindValue(":Facility_Name", $facilityName);
                $emailStatement->bindParam(":Subject", $subject);
                $emailStatement->bindParam(":Body", $body);
                $emailStatement->bindValue(":Date", date('Y-m-d'));
                $emailStatement->execute();

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new infected record</title>
</head>

<body>

    <h1>Add new infected record</h1>

    <form action="./create.php" method="post">
        <label for="Medicare_Number">Medicare Number</label>
        <select name="Medicare_Number" id="Medicare_Number">
            <option value="">--Please choose an option--</option>
            <?php while ($row = $employeesStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Medicare_Number"]; ?>">
                    <?php echo $row["Medicare_Number"]; ?>
                </option>
            <?php } ?>
        </select>

        <br>

        <label for="Infection_Type">Infection Type</label>
        <select name="Infection_Type" id="Infection_Type">
            <option value="">--Please choose an option--</option>
            <?php while ($row = $infectionsStatement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option value="<?php echo $row["Infection_Type"]; ?>">
                    <?php echo $row["Infection_Type"]; ?>
                </option>
            <?php } ?>
        </select>

        <br />

        <label for="Date">Date</label>
        <input type="date" name="Date" id="Date"> <br />

        <button type="submit">Add</button>
    </form>
    <a href="./">Back to Infected list</a>

</body>

</html>