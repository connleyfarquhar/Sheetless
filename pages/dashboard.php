<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modal.css">
    <script src="../scripts/modal.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=Signika+Negative" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <title>Dashboard</title>
</head>

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

<body>
    <div class="template-container">
        <div class="template-wrapper">
            <div class="template-grid">
                <div class="template-card">
                    <div class="template-image-container">
                        <img src="../images/Prod-Traveller-IMG.png" alt="Traveller Template Image 1">
                    </div>
                    <div class="template-info">
                        <h3>Traveller Group #1</h3>
                        <p>Current Revision: <span class="spanRevision">01</span></p>
                    </div>
                    <a href="../pages/travellerdata.php" class="template-button">Use Template</a>
                </div>
                <div class="template-card">
                    <div class="template-image-container">
                        <img src="../images/Prod-Traveller-IMG.png" alt="Traveller Template Image 2">
                    </div>
                    <div class="template-info">
                        <h3>Traveller Group #2</h3>
                        <p>Current Revision: <span class="spanRevision">01</span></p>
                    </div>
                    <a href="../pages/travellerdata2.php" class="template-button">Use Template</a>
                </div>
            </div>
        </div>
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