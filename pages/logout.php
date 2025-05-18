<?php
session_start();
session_unset();  
session_destroy(); 

// Redirect the end user to index.php upon logout buttion being clicked.
header("Location: http://localhost/Sheetless/index.php");
exit;
?>