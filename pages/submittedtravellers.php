<?php
session_start();

// Used PHP Objects to create a login class that is used throughout most pages in the system to validate the login session for the user.
class login {
    public function validateLogin() {
        if (!isset($_SESSION['username'])) {
            header("Location: ../index.php");
            exit;
        }
    }
}

// Creating a new login Instance and calling validateLogin to check if the end user is logged in, if not then the user will be at Index.PHP.
$login = new login();
$login -> validateLogin();

?>

<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sheetless";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php

// Searches for Data that was inputted within the startDate and endDate Range.
$where = "";
if (isset($_GET['start']) && isset($_GET['end'])) {
    $startDate = $conn->real_escape_string($_GET['start']);
    $endDate = $conn->real_escape_string($_GET['end']);
    $where = " WHERE date_submitted BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
}

// Selecting all from traveler_data table, within the start and end date range it then is stored within the output variable for further use.
$sql = "SELECT * FROM traveler_data" . $where . " ORDER BY date_submitted DESC";
$travelerDataOutput = $conn->query($sql);

// Selecting all from traveler_data2 table, within the start and end date range it then is stored within the output variable for further use.
$sql2 = "SELECT * from traveler_data2" . $where . " ORDER BY date_submitted DESC";
$travelerData2Output = $conn->query($sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">

    <title>Submitted Travellers</title>
</head>

<!-- Header displayed on all pages of the system excluding index.php where the login portal is. Header contains page navigation links and displays which account is logged in. -->
<!-- Using PHP, i have managed to create a process that will check which account is logged in to display certain page navigation links that other accounts may not see such as Traveller Revisions. Clicking logout takes you back to Index.PHP.-->
<header>
    <div class="logo">
        <img src="../images/DTS.png" alt="Logo">
    </div>
    <nav>
        <ul>
            <li><a href="../pages/dashboard.php">Dashboard</a></li>
            <li><a href="../pages/submittedtravellers.php">Submitted Travellers</a></li>
            
            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <li><a href="../pages/revisions.php">Traveller Revisions</a></li>
            <?php endif; ?>
            
            <li class="user-info">Logged in as: <?php print htmlspecialchars($_SESSION['username']); ?></li>
            <li><a href="logout.php">Logout</a></li>

            <?php else: ?>
                <li><a href="index.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<a class="exportbutton" href="exporttravellers.php"><button>Export Traveller Group 1 Data</button></a>
<a class="exportbutton" href="exporttravellers2.php"><button>Export Traveller Group 2 Data</button></a>

<div class="search-container">
    <form method="GET" action="">
        <input type="text" name="search_id" placeholder="Search by Traveller ID..">
        <button type="submit">Search</button>
    </form>
</div>

<div class="submitted-container">
    <div class="submitted-box">
        <h1>Submitted Travellers Group 1</h1>
        
        <?php
        // Display Group 1 travellers
        if ($travelerDataOutput->num_rows > 0) {
            while($row = $travelerDataOutput->fetch_assoc()) {
                print '<div class="traveller-item">';
                print '<div class="traveller-header">';
                print '<span>Traveller Group 1 ID: <strong>' . $row["id"] . '</strong></span>';
                print '<span>Submitted: <strong>' . date('F j, Y, g:i a', strtotime($row["date_submitted"])) . '</strong></span>';
                print '</div>';
               
                print '<ul class="product-list">';
               
                // Defining the step names for Group 1
                $travellerProcess = [
                    'step_1' => 'Step 1',
                    'step_2' => 'Step 2',
                    'step_3' => 'Step 3',
                    'step_4' => 'Step 4',
                    'step_5' => 'Step 5',
                    'step_6' => 'Step 6',
                    'step_7' => 'Step 7',
                    'step_8' => 'Step 8',
                    'step_9' => 'Step 9',
                    'step_10' => 'Step 10',
                    'step_11' => 'Step 11',
                    'step_12' => 'Step 12',
                    'step_13' => 'Step 13',
                    'step_14' => 'Step 14',
                    'step_15' => 'Step 15',
                    'step_16' => 'Step 16',
                    'step_17' => 'Step 17',
                    'step_18' => 'Step 18',
                    'step_19' => 'Step 19',
                    'step_20' => 'Step 20'
                ];
                
                // Using a foreach statement to correctly output each process of the traveller sheet onto SubmittedTravellers.PHP.
                foreach ($travellerProcess as $column => $label) {
                    $status = !empty($row[$column]) ? 'Completed: ' . $row[$column] : 'Not completed';
                    print '<li class="product-item">';
                    print '<span class="product-name">' . $label . ':</span> ';
                    print '<span class="product-details' . (empty($row[$column]) ? ' pending' : '') . '">' . $status . '</span>';
                    print '</li>';
                }
                print '</ul>';
                print '</div>';
            }
        } 
        ?>
        
        <h1>Submitted Travellers Group 2</h1>
        
        <?php
        // Display Group 2 travellers
        if ($travelerData2Output->num_rows > 0) {
            while($row = $travelerData2Output->fetch_assoc()) {
                print '<div class="traveller-item traveler-data2">';
                print '<div class="traveller-header">';
                print '<span>Traveller Group 2 ID: <strong>' . $row["id"] . '</strong></span>';
                print '<span>Submitted: <strong>' . date('F j, Y, g:i a', strtotime($row["date_submitted"])) . '</strong></span>';
                print '</div>';
                
                print '<ul class="product-list">';
                
                // Defining the step names for Group 2
                $travellerProcess = [
                    'step_21' => 'Step 21',
                    'step_22' => 'Step 22',
                    'step_23' => 'Step 23',
                    'step_24' => 'Step 24',
                    'step_25' => 'Step 25',
                    'step_26' => 'Step 26',
                    'step_27' => 'Step 27',
                    'step_28' => 'Step 28',
                    'step_29' => 'Step 29',
                    'step_30' => 'Step 30',
                    'step_31' => 'Step 31',
                    'step_32' => 'Step 32',
                    'step_33' => 'Step 33',
                    'step_34' => 'Step 34',
                    'step_35' => 'Step 35',
                    'step_36' => 'Step 36',
                    'step_37' => 'Step 37',
                    'step_38' => 'Step 38',
                    'step_39' => 'Step 39',
                    'step_40' => 'Step 40'
                ];
                
                // Using a foreach statement to output each process of the traveller sheet onto SubmittedTravellers.PHP. 
                foreach ($travellerProcess as $column => $label) {
                    $status = !empty($row[$column]) ? 'Completed: ' . $row[$column] : 'Not completed';
                    print '<li class="product-item">';
                    print '<span class="product-name">' . $label . ':</span> ';
                    print '<span class="product-details' . (empty($row[$column]) ? ' pending' : '') . '">' . $status . '</span>';
                    print '</li>';
                }
                
                print '</ul>';
                print '</div>';
            }
        } 
        
        $conn->close();
        ?>
    </div>
</div>

<!-- Footer displayed on all pages on the system. -->
<footer class="footer">
                <div class="footer-container">

                    <div class="footer-about">
                        <h2>About Us</h2>
                        <p>SheetLess is a Digital Production Traveller System that allows for taking what was a paper-based system into a fully-fledged digital system to access, edit, manage and store Digitalised Production Travellers.</p>
                        <br>
                        <p class="footer-copyright">© 2025 Connley Farquhar. All Rights Reserved.</p>
                    </div>

                    <!-- Various footer links to Social Media Profiles. -->
                    <div class="footer-logo">
                        <img src="../images/DTS.png" alt="Logo">
                        <div class="social-icons">
                            <a href="https://github.com/connleyfarquhar" target="_blank"><img src="../images/github.png" alt="GitHub Profile"></a>
                            <a href="https://www.linkedin.com/in/connleyfarquhar/" target="_blank"><img src="../images/linkedin.png" alt="Linkedin Profile"></a>
                        </div>
                    </div>
                </div>
            </footer>