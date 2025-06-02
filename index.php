<?php

// Start the session.
session_start();
$dbConfig = new DatabaseConfig();
// Create Database connection.
$database = new Database($dbConfig);
// Authenticate Database connection.
$auth = new validateConnection($database);
// Initialise a new controller for the login system.
$controller = new LoginController($auth);

// Process initial request to login.
$controller->processLogin();

// Close database connection.
$database->closeConnection();

// Display the login page
$controller->displayLoginPage();

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

// validateConnection class is created to handle the login system from start to finish to ensure users can log in correctly with no issue.
class validateConnection {
    private $db;
    private $errorMessage = "";
    
    // Constructor initialised for database connection.
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    // Function is used to check if the login input meets the same credentials as the login table in the database. 
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT userPassword, accountID FROM sheetlesslogin WHERE userName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_password, $account_id);
            $stmt->fetch();
            
            // Verify the password using password_verify
            if (password_verify($password, $db_password)) {
                $this->setSession($username, $account_id);
                $stmt->close();
                return true;
            } else {
                $this->errorMessage = "Incorrect Username or Password.";
            }
        } else {
            $this->errorMessage = "Error, Try Again.";
        }
        
        $stmt->close();
        return false;
    }
    
    // Function sets a session for when the user has successfully logged in.
    private function setSession($username, $account_id) {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        
        if ($account_id == 1) {
            $_SESSION['role'] = 'admin';
        } else if ($account_id == 2) {
            $_SESSION['role'] = 'user';
        } else {
            $_SESSION['role'] = 'user';
        }
    }
    
    // In the event of login failure, function is called to return the error message.
    public function getErrorMessage() {
        return $this->errorMessage;
    }
}

// LoginController class handles the login process and displaying of the login page.
class LoginController {
    private $auth;
    private $errorMessage = "";
    
    // Constructor function that handles authentication.
    public function __construct(validateConnection $auth) {
        $this->auth = $auth;
    }
    
    // Processing login request via form submission from end user.
    public function processLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if ($this->auth->login($username, $password)) {
                header("Location: pages/dashboard.php");
                exit;
            } else {
                $this->errorMessage = $this->auth->getErrorMessage();
            }
        }
    }
    
    // Function called to display error message if any error occurs during login
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    
    // Function to display the login page to the end user, mostly built with HTML, CSS and JavaScript.
    public function displayLoginPage() {
        $errorMessage = $this->errorMessage;
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">
            <link rel="icon" type="image/x-icon" href="images/favicon.ico">
            <title>System Access Portal</title>
        </head>
        <body>
            <div class="login-container">
                <div class="login-logo-container">
                    <img src="images/DTS.png" alt="Logo">
                </div>
                <h2>System Access Portal</h2>

                <h5><span class="span">Authorised Users Only.</span></h5>
               
                <!-- IF statement, if input is empty display error message. -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="error-message">
                        <?php print $errorMessage; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Standard HTML form for the login page on Index.PHP -->
                <form id="login-form" method="POST" action="index.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                   
                    <button class="submit-button" type="submit">Login</button>
                </form>
                
                <p class="signup-link">Don't have an account? <a href="http://localhost/Sheetless/pages/signup.php">Sign up here</a></p>
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
                        <img src="images/DTS.png" alt="Logo">
                        <div class="social-icons">
                            <a href="https://github.com/connleyfarquhar" target="_blank"><img src="images/github.png" alt="GitHub Profile"></a>
                            <a href="https://www.linkedin.com/in/connleyfarquhar/" target="_blank"><img src="images/linkedin.png" alt="Linkedin Profile"></a>
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