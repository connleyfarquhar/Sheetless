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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <title>Traveller Revisions</title>
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
            
            <li class="user-info">Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?></li>
            <li><a href="logout.php">Logout</a></li>

            <?php else: ?>
                <li><a href="index.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

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