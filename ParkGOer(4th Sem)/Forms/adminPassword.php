<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For password and username</title>
    <link rel="stylesheet" href="formStylesheet.css">
    <?php
        define('BASE_URL', 'http://localhost/VMSproject');
        //to embedded the php code of creating connection with database
        include 'createConnection.php';

        //Checking if the variable is acquired through 'GET' method
        if(isset($_GET['adminID'])){
            $AdminId=$_GET['adminID'];//put the key value into a variable

            if($_SERVER['REQUEST_METHOD']=="POST"){
            //Getting values from the form with POST method
                $username=$_POST['Username'];

                $sqlCheck = $conn->prepare("SELECT Username FROM admin WHERE Username = ?");
                $sqlCheck->bind_param("s", $username);
                $sqlCheck->execute();
                $result = $sqlCheck->get_result();

                // Check email existence
                if ($result->num_rows > 0) {
                    echo "<script>
                                alert('Username already exists');
                            </script>";
                    exit();
                }

                $password=$_POST['ConfirmPassword'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                //Updating username and password values into the database table 'Admin' where ID=Key variable
                $sql=$conn->prepare("UPDATE Admin SET Username=?, Password=? WHERE A_id=?;");
                $sql->bind_param("ssi", $username, $hashedPassword, $AdminId);

                //If the SQL code sucessfully executed, redirect to login page
                if($sql->execute()===TRUE){
                    echo "<script>
                            alert('Registration Sucessful.');
                            window.location.href = '" . BASE_URL . "/Forms/adminLogin.php';
                        </script>";
                    exit();
                }
                else{
                    echo"<script>
                        alert ('Something went worng. Try again!');
                    </script>";
                    exit();
                }
            }
        }
        else{
            echo "ID not found";
        }
        
    ?>
    
    <script>
        function check(){
        const username=document.getElementById("Username").value.trim();
        var createpass=document.getElementById("CreatePassword").value.trim();
        var confirmpass=document.getElementById("ConfirmPassword").value.trim();

        const regExpUser= /^[a-zA-Z0-9_\.]{3,20}$/;

        //Reset Error Message
        document.getElementById("usernameErr").style.display = "none";
        document.getElementById("createPassErr").style.display = "none";
        document.getElementById("confirmPassErr").style.display = "none";

        if(!regExpUser.test(username)){
            document.getElementById("usernameErr").innerHTML="!!!Please Enter valid alphanumeric Username(_ and . are allowed)!";
            document.getElementById("usernameErr").style.display = "block";  // Show error
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
    <div>
    <div class="headerForm">
    <a href="initialPage.php">
        <img src="..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
    </a>
    </div>
    <div class="box">
    <p class="title">Create Username and Password</p>
    <form method="POST" onsubmit="return check()" autocomplete="off">
        <div class="formLine">
            <label>Enter a Username:</label> <input type="text" name="Username" id="Username" required>
        </div><br/>
        <span id="usernameErr"></span>

        <div class="formLine">
            <label>Create Password:</label> <input type="password" name="CreatePassword" id="CreatePassword" required>
        </div><br/>
        <span id="createPassErr"></span>

        <div class="formLine">
            <label>Confirm Password:</label><input type="password" name="ConfirmPassword" id="ConfirmPassword" required>
        </div><br/>
        <span id="confirmPassErr"></span>

        <input type="submit" class="button" value="Register">
    </form>
    </div>
    </div>
</body>
</html>