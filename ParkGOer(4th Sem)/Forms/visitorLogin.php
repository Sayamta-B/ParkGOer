<?php
    session_start();

    define('BASE_URL', 'http://localhost/VMSproject');
    //to embedded the php code of creating connection with database
    include 'createConnection.php';
    

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $checkPass=NULL;
        $username=$_POST['V_UserNameOremail'];
        $password=$_POST['V_Password'];
        
        $sql = $conn->prepare("SELECT V_id, V_username,V_email, V_password FROM visitor WHERE V_username=? OR V_email=?;");
        $sql->bind_param("ss",$username,$username);
        $sql->execute();
        $result=$sql->get_result();

        if($result->num_rows > 0){            
            while($row = $result->fetch_assoc()){
                $_SESSION['V_id']=$row["V_id"];
                $storedPasswordHash = $row["V_password"];
                $_SESSION["V_username"] = $row["V_username"];
                $_SESSION["V_email"] = $row["V_email"];
            }
            
            // Now compare the user-inputted password with the one from the database
            if (password_verify($password, $storedPasswordHash)) {
                $_SESSION["loggedin"] = true; //the user is logged in
                // Redirect to the admin homepage on success
                header("Location: ../User/userHomepage.php");
                exit();
            } else {
                echo"<script>
                    alert ('Incorrect Password!');
                    window.location.href = '" . BASE_URL . "/Forms/visitorLogin.php';
                </script>";
                exit();
            }
        }
        else{
            echo"<script>
                alert ('Username or Email not found!');
                window.location.href = '" . BASE_URL . "/Forms/visitorLogin.php';
            </script>";
            exit();
        }  
    }
    $conn->close();      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Sign-In</title>
    <link rel="stylesheet" href="formStylesheet.css">

    <script>
        function checkEmpty(){
            var username=document.getElementsByName("V_UserNameOremail")[0].value;
            var password=document.getElementsByName("V_Password")[0].value;

            //Reset Error Message
            document.getElementById("V_identifierErr").style.display = "none";
            document.getElementById("V_passwordErr").style.display = "none";

            if(username===""){
                document.getElementById("V_identifierErr").innerHTML="!!!Please Enter Username!!!";
                document.getElementById("V_identifierErr").style.display = "block";  // Show error
                return false;
            }
            else if(password===""){
                document.getElementById("V_passwordErr").innerHTML="!!!Please Enter password!!!";
                document.getElementById("V_passwordErr").style.display = "block";  // Show error
                return false;
            }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
    <div class="headerForm">
    <a href="../initialPage.php">
        <img src="..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
    </a>
    </div>
    <div class="box">
    <p class="title">Visitor Log In</p>

        <form method="POST" onsubmit="return checkEmpty()" autocomplete="off">
        <div class="formLine">
            <input type="text" name="V_UserNameOremail" placeholder="Username or Email">
        </div>
        <span id="V_identifierErr"></span><br/>
            
        <div class="formLine">
        <input type="password" name="V_Password" placeholder="Password">
        </div>
        <span id="V_passwordErr"></span><br/><br/>

            <input type="submit" value="Log-in" class="button">
            <p>Dont have an account?</p> <a href="visitorSignUp.php">Register now!</a>
        </form>
    </div>
    </div>
</body>
</html>