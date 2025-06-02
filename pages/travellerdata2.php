<?php
session_start();

// Creation of Database Class.
class Database {
    private $conn;
    private $localhost = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "sheetless";

    // Function that creates a connection to the database.
    public function __construct() {
        $this->conn = new mysqli($this->localhost, $this->username, $this->password, $this->dbname);
        
        // Check if the connection was successful, if not throw an error.
        if ($this->conn->connect_error) {
            die("The Connection has Failed: " . $this->conn->connect_error);
        }
    }

    // Function that gets the connection between the database and the form.
    public function getConnection() {
        return $this->conn;
    }

    // Closing Database Connection Instance.
    public function close() {
        $this->conn->close();
    }
}

// TravellerForm class is in control of the process of submitting traveller form submissions to the database.
class travellerForm {
    private $db;
    private $conn;
    
    // Creating a constructor to hold and work with the database connection.
    public function __construct(Database $db) {
        $this->db = $db;
        $this->conn = $db->getConnection();
    }
    
    // Function that handles the overall form submiission in the submit button.
    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (isset($_POST['submit-traveler-continued'])) {
                $this->processTravelerSubmission();
            }
        }
    }
    
    // Function that formats the field data to be inserted into the database. It takes the name and date of the field and combines them into a single string.
    private function formatFieldData($name, $date) {
        return $name . " - " . $date;
    }
    
    // Main function that processes the entire traveller submission. It takes the user input from the form and successfully structures it to be inserted into the database table.
    private function processTravelerSubmission() {
    $formattedData = [
        'step_21' => $this->formatFieldData($_POST['step_21_name'], $_POST['step_21_date']),
        'step_22' => $this->formatFieldData($_POST['step_22_name'], $_POST['step_22_date']),
        'step_23' => $this->formatFieldData($_POST['step_23_name'], $_POST['step_23_date']),
        'step_24' => $this->formatFieldData($_POST['step_24_name'], $_POST['step_24_date']),
        'step_25' => $this->formatFieldData($_POST['step_25_name'], $_POST['step_25_date']),
        'step_26' => $this->formatFieldData($_POST['step_26_name'], $_POST['step_26_date']),
        'step_27' => $this->formatFieldData($_POST['step_27_name'], $_POST['step_27_date']),
        'step_28' => $this->formatFieldData($_POST['step_28_name'], $_POST['step_28_date']),
        'step_29' => $this->formatFieldData($_POST['step_29_name'], $_POST['step_29_date']),
        'step_30' => $this->formatFieldData($_POST['step_30_name'], $_POST['step_30_date']),
        'step_31' => $this->formatFieldData($_POST['step_31_name'], $_POST['step_31_date']),
        'step_32' => $this->formatFieldData($_POST['step_32_name'], $_POST['step_32_date']),
        'step_33' => $this->formatFieldData($_POST['step_33_name'], $_POST['step_33_date']),
        'step_34' => $this->formatFieldData($_POST['step_34_name'], $_POST['step_34_date']),
        'step_35' => $this->formatFieldData($_POST['step_35_name'], $_POST['step_35_date']),
        'step_36' => $this->formatFieldData($_POST['step_36_name'], $_POST['step_36_date']),
        'step_37' => $this->formatFieldData($_POST['step_37_name'], $_POST['step_37_date']),
        'step_38' => $this->formatFieldData($_POST['step_38_name'], $_POST['step_38_date']),
        'step_39' => $this->formatFieldData($_POST['step_39_name'], $_POST['step_39_date']),
        'step_40' => $this->formatFieldData($_POST['step_40_name'], $_POST['step_40_date'])
    ];
    
    // Using Prepared Statements to prevent SQL Injection attempts which increases overall system stability and security.
    try {
        $stmt = $this->conn->prepare("INSERT INTO traveler_data2 (
            step_21,
            step_22, 
            step_23, 
            step_24, 
            step_25, 
            step_26, 
            step_27, 
            step_28, 
            step_29, 
            step_30, 
            step_31, 
            step_32, 
            step_33, 
            step_34, 
            step_35, 
            step_36, 
            step_37, 
            step_38, 
            step_39, 
            step_40,
            date_submitted
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        
        // If all else fails, throw an error to the end user stating the attempt has failed.
        if ($stmt === false) {
            throw new Exception("SQL preparation failed: " . $this->conn->error);
        }
        
        // Bind the parameters to the prepared statement
        $stmt->bind_param(
            "ssssssssssssssssssss", 
            $formattedData['step_21'],
            $formattedData['step_22'],
            $formattedData['step_23'],
            $formattedData['step_24'],
            $formattedData['step_25'],
            $formattedData['step_26'],
            $formattedData['step_27'],
            $formattedData['step_28'],
            $formattedData['step_29'],
            $formattedData['step_30'],
            $formattedData['step_31'],
            $formattedData['step_32'],
            $formattedData['step_33'],
            $formattedData['step_34'],
            $formattedData['step_35'],
            $formattedData['step_36'],
            $formattedData['step_37'],
            $formattedData['step_38'],
            $formattedData['step_39'],
            $formattedData['step_40']
        );
        
        // Outputs a successful message on screen to show the user that the traveller was uploaded to the database.
        if ($stmt->execute()) {
            print "<p>Traveller Uploaded Successfully.</p>";
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        // Display an error message if an error is found in the process.
        print "<h3>Error:</h3>";
        print "<p>" . $e->getMessage() . "</p>";
    }
}
}

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

// Class that handles the displaying of general page content using mostly HTML, CSS & JavaScript.
// This page is used to display the form for the traveller.
class pageContent {
    public function renderPage() {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/autoDate.js"></script>
    <script src="../scripts/validation.js"></script>
    <script src="../scripts/initialSelector.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <title>Traveller #2</title>
</head>
<body>

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
            
            <!-- If account that is logged in as admin, display Traveller Revisions. -->
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

<div class="worker-selection-container">
    <div class="worker-initials-wrapper">
        <label for="worker_initials_select">Select Worker Initials:</label>
        <select id="worker_initials_select" name="worker_initials_select">
            <option value="">Select Initials</option>
            <option value="CF">CF</option>
            <option value="JP">JP</option>
            <option value="GI">GI</option>
            <option value="DG">DG</option>
            <option value="AB">AB</option>
        </select>
        <button type="button" class="worker-initials-apply-btn" onclick="applyInitials()">Apply Initials</button>
    </div>
</div>

<!-- Container for the traveller form for the BatFan Traveller Sheet, content displayed in a format of text > Input > Date which is automatically filled out with JavaScript. -->
<div class="container">
    <form class="traveller-form" method="POST" action="">
    <fieldset class="form-group">
        <div class="traveller-step">
            <label for="step_21_name">Step 21</label>
            <input type="text" id="step_21_name" name="step_21_name" placeholder="Input" required>
            <input type="date" id="step_21_date" name="step_21_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_22_name">Step 22</label>
            <input type="text" id="step_22_name" name="step_22_name" placeholder="Input" required>
            <input type="date" id="step_22_date" name="step_22_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_23_name">Step 23</label>
            <input type="text" id="step_23_name" name="step_23_name" placeholder="Input" required>
            <input type="date" id="step_23_date" name="step_23_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_24_name">Step 24</label>
            <input type="text" id="step_24_name" name="step_24_name" placeholder="Input" required>
            <input type="date" id="step_24_date" name="step_24_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_25_name">Step 25</label>
            <input type="text" id="step_25_name" name="step_25_name" placeholder="Input" required>
            <input type="date" id="step_25_date" name="step_25_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_26_name">Step 26</label>
            <input type="text" id="step_26_name" name="step_26_name" placeholder="Input" required>
            <input type="date" id="step_26_date" name="step_26_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_27_name">Step 27</label>
            <input type="text" id="step_27_name" name="step_27_name" placeholder="Input" required>
            <input type="date" id="step_27_date" name="step_27_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_28_name">Step 28</label>
            <input type="text" id="step_28_name" name="step_28_name" placeholder="Input" required>
            <input type="date" id="step_28_date" name="step_28_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_29_name">Step 29</label>
            <input type="text" id="step_29_name" name="step_29_name" placeholder="Input" required>
            <input type="date" id="step_29_date" name="step_29_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_30_name">Step 30</label>
            <input type="text" id="step_30_name" name="step_30_name" placeholder="Input" required>
            <input type="date" id="step_30_date" name="step_30_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_31_name">Step 31</label>
            <input type="text" id="step_31_name" name="step_31_name" placeholder="Input" required>
            <input type="date" id="step_31_date" name="step_31_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_32_name">Step 32</label>
            <input type="text" id="step_32_name" name="step_32_name" placeholder="Input" required>
            <input type="date" id="step_32_date" name="step_32_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_33_name">Step 33</label>
            <input type="text" id="step_33_name" name="step_33_name" placeholder="Input" required>
            <input type="date" id="step_33_date" name="step_33_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_34_name">Step 34</label>
            <input type="text" id="step_34_name" name="step_34_name" placeholder="Input" required>
            <input type="date" id="step_34_date" name="step_34_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_35_name">Step 35</label>
            <input type="text" id="step_35_name" name="step_35_name" placeholder="Input" required>
            <input type="date" id="step_35_date" name="step_35_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_36_name">Step 36</label>
            <input type="text" id="step_36_name" name="step_36_name" placeholder="Input" required>
            <input type="date" id="step_36_date" name="step_36_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_37_name">Step 37</label>
            <input type="text" id="step_37_name" name="step_37_name" placeholder="Input" required>
            <input type="date" id="step_37_date" name="step_37_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_38_name">Step 38</label>
            <input type="text" id="step_38_name" name="step_38_name" placeholder="Input" required>
            <input type="date" id="step_38_date" name="step_38_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_39_name">Step 39</label>
            <input type="text" id="step_39_name" name="step_39_name" placeholder="Input" required>
            <input type="date" id="step_39_date" name="step_39_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_40_name">Step 40</label>
            <input type="text" id="step_40_name" name="step_40_name" placeholder="Input" required>
            <input type="date" id="step_40_date" name="step_40_date" value="" required>
        </div>
        <button type="submit" name="submit-traveler-continued">Submit</button>
    </fieldset>
</form>
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
</body>
</html>
        <?php
    }
}

// Creating a new Database instance that will allow for the traveller form submission to be submitted to the database.
$db = new Database();

$travellerForm = new travellerForm($db);
$travellerForm-> handleFormSubmission();

// Creating a new pageContent Instance to display all page content for BatFan Traveller.
$pageContent = new pageContent();
$pageContent -> renderPage();

$db->close();
?>