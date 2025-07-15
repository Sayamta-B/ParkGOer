<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket Information</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
    <script>
        function validateRides(){
            var capacity= document.getElementById("Capacity").value.trim();
            var price= document.getElementById("R_Price").value.trim();

            if(capacity<0){
                alert("Capacity cannot be in negative");
                return false;
            }
            else if(price<0){
                alert("Price cannot be in negative");
                return false;
            }
            else{
                return true;
            }
        }
    </script>

    <?php
        session_start();
        include '../../Forms/createConnection.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql=$conn->prepare("SELECT * FROM Rides WHERE R_id=?;");
            $sql->bind_param("i", $id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows > 0) {
                $ride = $result->fetch_assoc();
            } else {
                echo "Ticket not found!";
                exit();
            }
        }
        else{
            echo "Ticket not found";
        }
    ?>
</head>
<body>
    <div class="verticalBar">
            <ul class="verticalNavBar">
                <li class="NavElements">
                    <a href="http://localhost/VMSproject/Admin/adminHomepage.php" class="NavElements">My Dashboard</a>
                </li>
                <li class="NavElements">
                    <a href="http://localhost/VMSproject/Admin/Tickets/ticketSection.php" class="NavElements">Ticket</a>
                </li>
                <li class="NavElements">
                    <a href="http://localhost/VMSproject/Admin/Rides/rideSection.php" class="active NavElements">Ride</a>
                </li>
            </ul>
        </div>
        <div class="header">
            <img src="..\..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
        </div>
    <div class="workingArea">
        <form action="updateRides.php" method="POST" onsubmit="return validateRides()">
            <fieldset>
                <h1>Update Rides</h1><br/><br/>
                Ride Id-> <?php echo htmlspecialchars($ride['R_id']); ?><br/><br/>
                <input type="hidden" name="rideId" value="<?php echo htmlspecialchars($ride['R_id']); ?>">
                Ride Status-> <?php echo htmlspecialchars($ride['Status']); ?><br/><br/>
		Currently in use-> <?php echo htmlspecialchars($ride['currentUsed']); ?><br/><br/>
		Tickets Available-> <?php echo htmlspecialchars($ride['ticketAvailable'])?><br/><br/></br>
                <center style="background:white;">Capacity:</center> <input type="number" value="<?php echo htmlspecialchars($ride['Capacity']); ?>" style="width:240px; background:white;" name="Capacity" id="Capacity"><br/>
                Ride Price: <input type="number" value="<?php echo htmlspecialchars($ride['R_Price']); ?>" style="width:240px;background:white;" name="R_Price" id="R_Price"><br/>
                Description: <br/><textarea style="width:600px; height:200px; background:white;" name="ride_desc" id="ride_desc">
				 	<?php echo htmlspecialchars($ride['ride_desc']);?>
				</textarea><br/>
                <input type="submit" value="Update" class="btn">
            </fieldset>
            </form>
    </div>
</body>

</html>