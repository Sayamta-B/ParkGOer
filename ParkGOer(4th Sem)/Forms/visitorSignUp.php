<?php
    //to embbed the php code of creating connection with database
    include 'createConnection.php';

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Getting values from the form with POST method
        $username=$_POST['username'];
        $sqlCheck = $conn->prepare("SELECT V_username FROM visitor WHERE V_username = ?");
        $sqlCheck->bind_param("s", $username);
        $sqlCheck->execute();
        $result = $sqlCheck->get_result();

        // Check email existence
        if ($result->num_rows > 0) {
            echo "<script>
                        alert('Username already exists');
			window.location.href = '" . BASE_URL . "/Forms/visitorSignUp.php';
                    </script>";
            exit();
        }

        $email=$_POST['Email'];
        $sqlEmail = $conn->prepare("SELECT V_email FROM visitor WHERE V_email = ?");
        $sqlEmail->bind_param("s", $email);
        $sqlEmail->execute();
        $result = $sqlEmail->get_result();

        // Check email existence
        if ($result->num_rows > 0) {
            echo "<script>
                        alert('Email already exists');
			window.location.href = '" . BASE_URL . "/Forms/visitorSignUp.php';
                    </script>";
            exit();
        }

        $password=$_POST['CreatePassword'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //Inserting values into the database table 'Admin'
        $sql=$conn->prepare("INSERT INTO visitor(V_username, V_email, V_password) VALUES (?,?,?);");
        $sql->bind_param("sss", $username, $email, $hashedPassword);
        //Check if SQL code sucessful
        if($sql->execute()===TRUE){     
            header("Location: visitorLogin.php");
            //to redirect to another page and
            //send the variable in key-value pair, where '?' represents beginning of query string
            //'key' is the variable available in redirected page through get method
        }
        else{
            echo "Something went wrong.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Sign Up</title>
    <link rel="stylesheet" href="formStylesheet.css">
    <script>
        function check(){
            var username= document.getElementById("username").value.trim();            
            const regExpUser= /^[a-zA-Z0-9_\.]{3,20}$/;

            var email= document.getElementsByName("Email")[0].value;
            var regExpEmail=/^[a-zA-Z]+[a-zA-Z0-9_!#$%&]{2,}@[a-zA-Z]+\.[a-zA-Z]{2,}/;

            var createpass= document.getElementById("CreatePassword").value.trim();
            var confirmpass= document.getElementById("ConfirmPassword").value.trim();
            
            // Reset error messages initially
            document.getElementById("usernameErr").style.display = "none";
            document.getElementById("emailErr").style.display = "none";
            document.getElementById("createPassErr").style.display = "none";
            document.getElementById("confirmPassErr").style.display = "none";

            if(!regExpUser.test(username)){
                document.getElementById("usernameErr").innerHTML="!!!Please Enter valid alphanumeric Username(_ and . are allowed)!";
                document.getElementById("usernameErr").style.display = "block";  // Show error
                return false;
            }
            else if(!regExpEmail.test(email)){
                document.getElementById("emailErr").innerHTML="!!!Invalid email!!!";
                document.getElementById("emailErr").style.display = "block";  // Show error
                return false;
            }
            else if(createpass.length<8){
                document.getElementById("createPassErr").innerHTML="!!!Password is too short!!!";
                document.getElementById("createPassErr").style.display = "block";  // Show error
                return false;
            }
            else if(confirmpass===""){
                document.getElementById("confirmPassErr").innerHTML="!!!Please Enter to confirm password!!!";
                document.getElementById("confirmPassErr").style.display = "block";  // Show error
                return false;
            }
            else if(confirmpass!==createpass){
                document.getElementById("confirmPassErr").innerHTML="!!!Create Password and Confirm Password do not match.!!!";
                document.getElementById("confirmPassErr").style.display = "block";  // Show error
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
    <a href="initialPage.php">
        <img src="..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
    </a>
    </div>
    <div class="box">
    <p class="title">Visitor Sign Up</p>
    <form method="POST" onsubmit="return check()" autocomplete="off">
        <div class="formLine">
            <label>Enter Username:</label> <input type="text" name="username" id="username" required>
        </div>
        <span id="usernameErr"></span>

       <div class="formLine">
            <label>Enter Email:</label> <input type="text" name="Email" id="Email" required>
        </div>
        <span id="emailErr"></span>

        <div class="formLine">
            <label>Create Password:</label> <input type="password" name="CreatePassword" id="CreatePassword" required>
        </div>
        <span id="createPassErr"></span>

        <div class="formLine">
            <label>Confirm Password:</label><input type="password" name="ConfirmPassword" id="ConfirmPassword" required>
        </div>
        <span id="confirmPassErr"></span><br/><br/>

        <input type="submit" class="button" value="Sign-up">
    </form>
    </div>
    </div>
</body>
</html>