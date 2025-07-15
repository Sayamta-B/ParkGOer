<?php
    session_start(); // Start the session to access session variables

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        session_unset(); //Remove all session variable
        session_destroy(); //Destroy session
        echo"<script>
            alert('You have been logged out!!');
            window.location.href = 'adminLogin.php';
        </script>";
        exit();
    } 
    else {
        header("Location: ../initialPage.php"); // Redirect if not logged in
        exit();
    }
?>
