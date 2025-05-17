<?php

// Start the session.
session_start();
$dbConfig = new DatabaseConfig();
// Create Database connection.
$database = new Database($dbConfig);
// Initialize a new controller for the signup system.
$controller = new SignupController($database);

// Process signup request
$controller->processSignup();

// Close database connection.
$database->closeConnection();

// Display the signup page
$controller->displaySignupPage();

// Database config class
class DatabaseConfig {
    private $host = "localhost";
    private $dbname = "sheetless";
    private $username = "root";
    private $password = "";
    
    public function getHost() { return $this->host; }
    public function getDbname() { return $this->dbname; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
}

// Database connection class.
class Database {
    private $conn;
    
    // Function creates a constructor to start the database connection, taking from DatabaseConfig class
    public function __construct(DatabaseConfig $config) {
        $this->conn = new mysqli(
            $config->getHost(),
            $config->getUsername(),
            $config->getPassword(),
            $config->getDbname()
        );
        
        // Checking for initial connection, if any issues arise then display a connection error.
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    // Return connection.
    public function getConnection() {
        return $this->conn;
    }
    
    // Closes connection to the database.
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Prepares SQL statement.
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
}

// SignupController class handles the signup process and displaying of the signup page.
class SignupController {
    private $db;
    private $errorMessage = "";
    private $successMessage = "";
    
    // Constructor function that takes database connection.
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    // Processing signup request via form submission from end user.
    public function processSignup() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);
            
            // Basic validation
            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $this->errorMessage = "All fields are required.";
                return;
            }
            
            if ($password !== $confirmPassword) {
                $this->errorMessage = "Passwords do not match.";
                return;
            }
            
            // Check if username already exists
            $checkStmt = $this->db->prepare("SELECT userName FROM sheetlesslogin WHERE userName = ?");
            $checkStmt->bind_param("s", $username);
            $checkStmt->execute();
            $checkStmt->store_result();
            
            if ($checkStmt->num_rows > 0) {
                $this->errorMessage = "Username already exists.";
                $checkStmt->close();
                return;
            }
            $checkStmt->close();

            try {
                
                $nextIdStmt = $this->db->prepare("SELECT MAX(accountID) + 1 AS next_id FROM sheetlesslogin");
                $nextIdStmt->execute();
                $nextIdResult = $nextIdStmt->get_result();
                $nextIdRow = $nextIdResult->fetch_assoc();
                $nextId = $nextIdRow['next_id'];
                
                if ($nextId === null) {
                    $nextId = 1;
                }
                
                $nextIdStmt->close();
                
                // Hashing the password for extra security for the end user and or system.
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $insertStmt = $this->db->prepare("INSERT INTO sheetlesslogin (accountID, userName, userPassword) VALUES (?, ?, ?)");
                $insertStmt->bind_param("iss", $nextId, $username, $hashedPassword);
                
                if ($insertStmt->execute()) {
                    $this->successMessage = "Account Created Successfully.";
                } else {
                    throw new Exception($insertStmt->error);
                }
                $insertStmt->close();
            } catch (Exception $e) {
                $this->errorMessage = "Error creating account: " . $e->getMessage();
            }
        }
    }
    
    // Function called to display error message if any error occurs during signup
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    
    // Function called to display success message
    public function getSuccessMessage() {
        return $this->successMessage;
    }
    
    // Function to display the signup page to the end user
    public function displaySignupPage() {
        $errorMessage = $this->errorMessage;
        $successMessage = $this->successMessage;
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=Signika+Negative" rel="stylesheet">
            <title>SheetLess - Create Account</title>
        </head>
        <body>
            <div class="login-container">
                <div class="login-logo-container">
                    <img src="../images/DTS.png" alt="Logo">
                </div>
                <h2>Create New Account</h2>
               
                <!-- Display error message if any -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="error-message">
                        <?php print $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <!-- Display success message if any -->
                <?php if (!empty($successMessage)): ?>
                    <div class="success-message">
                        <?php print $successMessage; ?>
                        <!-- <p><a href="http://localhost/DTS/index.php">Go to Login</a></p> -->
                    </div>
                <?php endif; ?>
                
                <!-- Sign up form -->
                <form id="signup-form" method="POST" action="signup.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                   
                    <button class="submit-button" type="submit">Create Account</button>
                </form>

                <p class="signup-link">Already have an account? <a href="http://localhost/Sheetless/index.php">Go to Login</a></p>
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
?>