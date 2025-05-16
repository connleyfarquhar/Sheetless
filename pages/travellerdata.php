<?php
session_start();

// Creation of Database Class.
class Database {
    private $conn;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "sheetless";

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }
}

class TravelerForm {
    private $db;
    private $conn;
    
    public function __construct(Database $db) {
        $this->db = $db;
        $this->conn = $db->getConnection();
    }
    
    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit-traveler'])) {
                $this->processTravelerSubmission();
            }
        }
    }
    
    private function formatFieldData($name, $date) {
        return $name . " - " . $date;
    }
    
    private function processTravelerSubmission() {
        $formattedData = [
            'step_1' => $this->formatFieldData($_POST['step_1_name'], $_POST['step_1_date']),
            'step_2' => $this->formatFieldData($_POST['step_2_name'], $_POST['step_2_date']),
            'step_3' => $this->formatFieldData($_POST['step_3_name'], $_POST['step_3_date']),
            'step_4' => $this->formatFieldData($_POST['step_4_name'], $_POST['step_4_date']),
            'step_5' => $this->formatFieldData($_POST['step_5_name'], $_POST['step_5_date']),
            'step_6' => $this->formatFieldData($_POST['step_6_name'], $_POST['step_6_date']),
            'step_7' => $this->formatFieldData($_POST['step_7_name'], $_POST['step_7_date']),
            'step_8' => $this->formatFieldData($_POST['step_8_name'], $_POST['step_8_date']),
            'step_9' => $this->formatFieldData($_POST['step_9_name'], $_POST['step_9_date']),
            'step_10' => $this->formatFieldData($_POST['step_10_name'], $_POST['step_10_date']),
            'step_11' => $this->formatFieldData($_POST['step_11_name'], $_POST['step_11_date']),
            'step_12' => $this->formatFieldData($_POST['step_12_name'], $_POST['step_12_date']),
            'step_13' => $this->formatFieldData($_POST['step_13_name'], $_POST['step_13_date']),
            'step_14' => $this->formatFieldData($_POST['step_14_name'], $_POST['step_14_date']),
            'step_15' => $this->formatFieldData($_POST['step_15_name'], $_POST['step_15_date']),
            'step_16' => $this->formatFieldData($_POST['step_16_name'], $_POST['step_16_date']),
            'step_17' => $this->formatFieldData($_POST['step_17_name'], $_POST['step_17_date']),
            'step_18' => $this->formatFieldData($_POST['step_18_name'], $_POST['step_18_date']),
            'step_19' => $this->formatFieldData($_POST['step_19_name'], $_POST['step_19_date']),
            'step_20' => $this->formatFieldData($_POST['step_20_name'], $_POST['step_20_date'])
        ];
        
        try {
            $stmt = $this->conn->prepare("INSERT INTO traveler_data (
                step_1, 
                step_2, 
                step_3, 
                step_4, 
                step_5, 
                step_6, 
                step_7, 
                step_8, 
                step_9, 
                step_10, 
                step_11, 
                step_12, 
                step_13, 
                step_14, 
                step_15, 
                step_16, 
                step_17, 
                step_18, 
                step_19, 
                step_20,
                date_submitted
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            
            if ($stmt === false) {
                throw new Exception("SQL preparation failed: " . $this->conn->error);
            }
            
            $stmt->bind_param(
                "ssssssssssssssssssss", 
                $formattedData['step_1'], 
                $formattedData['step_2'], 
                $formattedData['step_3'], 
                $formattedData['step_4'], 
                $formattedData['step_5'], 
                $formattedData['step_6'], 
                $formattedData['step_7'], 
                $formattedData['step_8'], 
                $formattedData['step_9'], 
                $formattedData['step_10'], 
                $formattedData['step_11'], 
                $formattedData['step_12'], 
                $formattedData['step_13'], 
                $formattedData['step_14'], 
                $formattedData['step_15'], 
                $formattedData['step_16'], 
                $formattedData['step_17'], 
                $formattedData['step_18'], 
                $formattedData['step_19'], 
                $formattedData['step_20']
            );
            
            if ($stmt->execute()) {
                print "<p>Traveller Uploaded Successfully.</p>";
            } else {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
            
            $stmt->close();
        } catch (Exception $e) {
            print "<h3>Error:</h3>";
            print "<p>" . $e->getMessage() . "</p>";
        }
    }
}

class login {
    public function validateLogin() {
        if (!isset($_SESSION['username'])) {
            header("Location: ../index.php");
            exit;
        }
    }
}

$login = new login();
$login->validateLogin();

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
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=stylesheet">
    <title>Traveller #1</title>

</head>
<body>
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

    <form class="traveller-form" method="POST" action="">
    <fieldset class="form-group">
        <div class="traveller-step">
            <label for="step_1_name">Step 1</label>
            <input type="text" id="step_1_name" name="step_1_name" placeholder="Input" required>
            <input type="date" id="step_1_date" name="step_1_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_2_name">Step 2</label>
            <input type="text" id="step_2_name" name="step_2_name" placeholder="Input" required>
            <input type="date" id="step_2_date" name="step_2_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_3_name">Step 3</label>
            <input type="text" id="step_3_name" name="step_3_name" placeholder="Input" required>
            <input type="date" id="step_3_date" name="step_3_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_4_name">Step 4</label>
            <input type="text" id="step_4_name" name="step_4_name" placeholder="Input" required>
            <input type="date" id="step_4_date" name="step_4_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_5_name">Step 5</label>
            <input type="text" id="step_5_name" name="step_5_name" placeholder="Input" required>
            <input type="date" id="step_5_date" name="step_5_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_6_name">Step 6</label>
            <input type="text" id="step_6_name" name="step_6_name" placeholder="Input" required>
            <input type="date" id="step_6_date" name="step_6_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_7_name">Step 7</label>
            <input type="text" id="step_7_name" name="step_7_name" placeholder="Input" required>
            <input type="date" id="step_7_date" name="step_7_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_8_name">Step 8</label>
            <input type="text" id="step_8_name" name="step_8_name" placeholder="Input" required>
            <input type="date" id="step_8_date" name="step_8_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_9_name">Step 9</label>
            <input type="text" id="step_9_name" name="step_9_name" placeholder="Input" required>
            <input type="date" id="step_9_date" name="step_9_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_10_name">Step 10</label>
            <input type="text" id="step_10_name" name="step_10_name" placeholder="Input" required>
            <input type="date" id="step_10_date" name="step_10_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_11_name">Step 11</label>
            <input type="text" id="step_11_name" name="step_11_name" placeholder="Input" required>
            <input type="date" id="step_11_date" name="step_11_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_12_name">Step 12</label>
            <input type="text" id="step_12_name" name="step_12_name" placeholder="Input" required>
            <input type="date" id="step_12_date" name="step_12_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_13_name">Step 13</label>
            <input type="text" id="step_13_name" name="step_13_name" placeholder="Input" required>
            <input type="date" id="step_13_date" name="step_13_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_14_name">Step 14</label>
            <input type="text" id="step_14_name" name="step_14_name" placeholder="Input" required>
            <input type="date" id="step_14_date" name="step_14_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_15_name">Step 15</label>
            <input type="text" id="step_15_name" name="step_15_name" placeholder="Input" required>
            <input type="date" id="step_15_date" name="step_15_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_16_name">Step 16</label>
            <input type="text" id="step_16_name" name="step_16_name" placeholder="Input" required>
            <input type="date" id="step_16_date" name="step_16_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_17_name">Step 17</label>
            <input type="text" id="step_17_name" name="step_17_name" placeholder="Input" required>
            <input type="date" id="step_17_date" name="step_17_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_18_name">Step 18</label>
            <input type="text" id="step_18_name" name="step_18_name" placeholder="Input" required>
            <input type="date" id="step_18_date" name="step_18_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_19_name">Step 19</label>
            <input type="text" id="step_19_name" name="step_19_name" placeholder="Input" required>
            <input type="date" id="step_19_date" name="step_19_date" value="" required>
        </div>
        <div class="traveller-step">
            <label for="step_20_name">Step 20</label>
            <input type="text" id="step_20_name" name="step_20_name" placeholder="Input" required>
            <input type="date" id="step_20_date" name="step_20_date" value="" required>
        </div>
        <button type="submit" name="submit-traveler">Submit</button>
    </fieldset>
</form>
</div>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-about">
            <h2>About Us</h2>
            <p>SheetLess is a Digital Production Traveller System that allows for taking what was a paper-based system into a fully-fledged digital system to access, edit, manage and store Digitalised Production Travellers.</p>
            <br>
            <p class="footer-copyright">© 2025 Connley Farquhar. All Rights Reserved.</p>
        </div>
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

$db = new Database();
$travelerForm = new TravelerForm($db);
$travelerForm->handleFormSubmission();
$pageContent = new pageContent();
$pageContent->renderPage();
$db->close();
?>