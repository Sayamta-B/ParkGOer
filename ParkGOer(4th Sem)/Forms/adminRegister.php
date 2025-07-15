<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration Page</title>
    <link rel="stylesheet" href="formStylesheet.css">
    
    <?php
        define('BASE_URL', 'http://localhost/VMSproject');
        //to embbed the php code of creating connection with database
        include 'createConnection.php';

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            //Getting values from the form with POST method
            $name=$_POST['fullName'];
            $DOB=$_POST['dob']; 
            $email=$_POST['Email'];
            $phone=$_POST['Phone_no'];

            
            $sqlCheckEmail = $conn->prepare("SELECT Email FROM admin WHERE Email = ?");
            $sqlCheckEmail->bind_param("s", $email);
            $sqlCheckEmail->execute();
            $resultEmail = $sqlCheckEmail->get_result();

            // Check email existence
            if ($resultEmail->num_rows > 0) {
                echo "<script>
                            alert('Email already exists');
                            window.location.href = '" . BASE_URL . "/Forms/adminRegister.php';
                        </script>";
                exit();
            } 

            // Prepare a query to check if the phone number exists
            $sqlCheckPhone = $conn->prepare("SELECT Phone_no FROM admin WHERE Phone_no = ?");
            $sqlCheckPhone->bind_param("s", $phone);
            $sqlCheckPhone->execute();
            $resultPhone = $sqlCheckPhone->get_result();

            // Check phone number existence
            if ($resultPhone->num_rows > 0) {
                echo "<script>
                        alert('Phone number already exists');
                        window.location.href = '" . BASE_URL . "/Forms/adminRegister.php';
                    </script>";
                exit();
            } 

            // If both email and phone number are unique, proceed to insert the data
            $sql = $conn->prepare("INSERT INTO Admin(A_Name, DOB, Email, Phone_no) VALUES (?, ?, ?, ?)");
            $sql->bind_param("sssi", $name, $DOB, $email, $phone);
            if ($sql->execute()) {
                $AdminID = $conn->insert_id;
                header("Location: adminPassword.php?adminID=$AdminID");
                exit();
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    ?>

    <script>
        function check() {
        let isValid = true;

        const fullname = document.getElementById("fullName").value.trim();
        const regExpName = /^[a-zA-Z\s]+$/;
        const email = document.getElementById("Email").value.trim();
        const regExpEmail = /^[a-zA-Z]+[a-zA-Z0-9_!#$%&’*+/=?^`{|}~-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
        const DOB = document.getElementById("dob").value.trim();
        const today = new Date();
        const dobDate = new Date(DOB);
        const phone= document.getElementById("Phone_no").value.trim();
        const regExpPhone = /^\+?(977)?98[0-9]{8}$/;

        document.getElementById("fullnameErr").style.display = "none";
        document.getElementById("dobErr").style.display = "none";
        document.getElementById("emailErr").style.display = "none";
        document.getElementById("phoneErr").style.display = "none";

        if (!regExpName.test(fullname)) {
            document.getElementById("fullnameErr").innerHTML = "!!!Please enter a valid full name!!!";
            document.getElementById("fullnameErr").style.display = "block";
            isValid = false;
        }

        if (DOB === "" || dobDate > today) {
            document.getElementById("dobErr").innerHTML = "!!!Please enter a valid DOB!!!";
            document.getElementById("dobErr").style.display = "block";
            isValid = false;
        }

        if (!regExpEmail.test(email)) {
            document.getElementById("emailErr").innerHTML = "!!!Invalid email format!!!";
            document.getElementById("emailErr").style.display = "block";
            isValid = false;
        }

        if (!regExpPhone.test(phone)) {
            document.getElementById("phoneErr").innerHTML = "!!!Invalid phone number format!!!";
            document.getElementById("phoneErr").style.display = "block";
            isValid = false;
        }

        return isValid;
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
    <p class="title">Admin Register</p>
    <form method="POST" onsubmit="return check()">
        <div class="formLine">
            <label>Enter Full Name:</label> <input type="text" name="fullName" id="fullName" required>
        </div>
        <span id="fullnameErr"></span>

        <div class="formLine">
            <label>Enter Date Of Birth:</label> <input type="date" name="dob" id="dob" required>
        </div>
        <span id="dobErr"></span>

        <div class="formLine">
            <label>Enter Email:</label> <input type="text" name="Email" id="Email" required>
        </div>
        <span id="emailErr"></span>

        <div class="formLine">
            <label>Enter Phone no:</label> <input type="number" name="Phone_no" id="Phone_no" required>
        </div><br><br>
        <span id="phoneErr"></span>

        <input type="submit" class="button" value="Next">
    </form>
    </div>
    </div>
</body>
</html>