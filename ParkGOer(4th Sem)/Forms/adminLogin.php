<?php
    session_start();

    define('BASE_URL', 'http://localhost/VMSproject');
    //to embedded the php code of creating connection with database
    include 'createConnection.php';
    

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $checkPass=NULL;
        $username=$_POST['UserName'];
        $password=$_POST['Password'];
        
        $sql = $conn->prepare("SELECT A_id, Username, Password FROM admin WHERE Username=?;");
        $sql->bind_param("s",$username);
        $sql->execute();
        $result=$sql->get_result();

        if($result->num_rows > 0){            
            while($row = $result->fetch_assoc()){
                $storedPasswordHash = $row["Password"];
                $_SESSION["Username"] = $row["Username"];
                $_SESSION["A_id"] = $row["A_id"];
            }
            
            // Now compare the user-inputted password with the one from the database
            if (password_verify($password, $storedPasswordHash)) {
                $_SESSION["loggedin"] = true; //the user is logged in
                // Redirect to the admin homepage on success
                header("Location: ../Admin/adminHomepage.php");
            } else {
                echo "<script>
                        alert('Incorrect Password!');
                        window.location.href = '" . BASE_URL . "/Forms/adminLogin.php';
                    </script>";
                exit();
            }

        }
        else{
            echo "<script>
                alert('Username not found!');
                window.location.href = '" . BASE_URL . "/Forms/adminLogin.php';
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
    <title>Admin Log-In</title>
    <link rel="stylesheet" href="formStylesheet.css">

    <script>
        function checkEmpty(){
            var username=document.getElementsByName("UserName")[0].value;
            var password=document.getElementsByName("Password")[0].value;

            //Reset Error Message
            document.getElementById("usernameErr").style.display = "none";
            document.getElementById("passwordErr").style.display = "none";

            if(username===""){
                document.getElementById("usernameErr").innerHTML="!!!Please Enter Username!!!";
                document.getElementById("usernameErr").style.display = "block";  // Show error
                return false;
            }
            else if(password===""){
                document.getElementById("passwordErr").innerHTML="!!!Please Enter password!!!";
                document.getElementById("passwordErr").style.display = "block";  // Show error
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
    <p class="title">Admin Sign In</p>

        <form method="POST" onsubmit="return checkEmpty()" autocomplete="off">
        <div class="formLine">
            <input type="text" name="UserName" placeholder="Username" required><br/>
        </div><br/>
        <span id="usernameErr"></span>
            
        <div class="formLine">
        <input type="password" name="Password" placeholder="Password" required><br/>
        </div><br/>
        <span id="passwordErr"></span>

            <input type="submit" value="Sign-in" class="button"><br/>
            <br/><br/>
            <p>Dont have an account?</p> <a href="adminRegister.php">Register now!</a>
        </form>
    </div>
    </div>
</body>
</html>