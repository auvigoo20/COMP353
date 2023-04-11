<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HFEST System</title>
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Welcome to the Health Facility Employee Status Tracking System!</h1>
        <p>Choose one of the following links:</p>
        <ul class="list-unstyled">
            <li class="mb-3">
                <a href="./employees/">All Employees</a>
                <ul class="list-unstyled ml-3">
                    <li><a href="./employees/Q14.php">Doctors Working in the Province of Quebec (Q14)</a></li>
                    <li><a href="./employees/nurses_with_highest_scheduled_hours.php">Nurses with highest number of scheduled hours (Q15)</a></li>
                </ul>
            </li>
            <li class="mb-3">
                <a href="./facilities/">Facilities</a>
                <ul class="list-unstyled ml-3">
                    <li><a href="./facilities/Q13.php/">Facilities Infected with COVID-19 in the Last 2 Weeks(Q13)</a></li>
                </ul>
            </li>
            <li class="mb-3"><a href="./infections/">Infections</a></li>  
            <li class="mb-3"><a href="./vaccines/">Vaccines</a></li>
            <li class="mb-3"><a href="./works/">Works</a></li>
            <li class="mb-3"><a href="./manages/">Managers</a></li>
            <li class="mb-3">
                <a href="./infected/">Infected Employees</a>
                <ul class="list-unstyled ml-3">
                    <li><a href="./infected/Q9.php/">Doctors Infected with COVID-19 in the Last 2 Weeks(Q9)</a></li>
                    <li><a href="./infected/doctors_nurses_infected_covid19_3_or_more.php/">Doctors and Nurses Infected with COVID-19 at Least 3 times (Q16)</a></li>
                    <li><a href="./infected/doctors_nurses_never_infected_covid19.php/">Doctors and Nurses who have Never been Infected with Covid-19(Q17)</a></li>
                </ul>
            </li>
            <li class="mb-3"><a href="./vaccinated/">Vaccinated Employees</a></li>
            <li class="mb-3"><a href="./scheduled/">Scheduled Employees</a></li>
            <li class="mb-3"><a href="./emails/">Emails logged</a></li>
        </ul>
    </div>   
    <!-- Bootstrap JS file (optional) -->
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
