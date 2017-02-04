<?php
session_start();
if (isset($_SESSION['Errors_R'])){
    echo "<h1>".$_SESSION['Errors_R']."</h1>";
    unset($_SESSION['Errors_R']);
}
?>
<a href="signup.php">Go to SignUp Page.</a>