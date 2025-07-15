<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="adminStylesheet.css">
    <?php
        session_start();
        include "../Forms/createConnection.php";

        $sqlcountrides="SELECT count(R_id) AS totalrides FROM Rides";
        $countRides=$conn->query($sqlcountrides);
        $row = $countRides->fetch_assoc();
        $rideCount = $row['totalrides'];

        $sqlcounttickets="SELECT count(T_id) AS totaltickets FROM tickets";
        $countTicket=$conn->query($sqlcounttickets);
        $row = $countTicket->fetch_assoc();
        $ticketCount = $row['totaltickets'];
    
        $sqlname="SELECT A_name FROM admin WHERE A_id=$_SESSION[A_id]";
        $name=$conn->query($sqlname);
        $row = $name->fetch_assoc();
        $A_name = $row['A_name'];
    ?>
</head>
<body>
    <div class="verticalBar">
        <ul class="verticalNavBar">
            <li class="NavElements">
                <a href="http://localhost/VMSproject/Admin/adminHomepage.php" class="active NavElements">My Dashboard</a>
            </li>
            <li class="NavElements">
                <a href="http://localhost/VMSproject/Admin/Tickets/ticketSection.php" class="NavElements">Ticket</a>
            </li>
            <li class="NavElements">
                <a href="http://localhost/VMSproject/Admin/Rides/rideSection.php" class="NavElements">Ride</a>
            </li>
        </ul>
    </div>
    <div class="header">
            <img src="..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
    </div>
        <div class="workingArea">
            <center><h1>WELCOME <?php echo "Admin<br/>" .$A_name?></h1></center><br/><br/>
            <div class="dashContainer">
            <div class="dashBox">
                Total Rides <br/>
                <p><?php echo $rideCount;?></p>
            </div>
            <div class="dashBox">
                Total Tickets <br/>
                <p><?php echo $ticketCount;?></p>
            </div>
            </div>

            <br/><br/>
            <a class="logout" href="../Forms/adminLogOut.php">Logout</a>
        </div>    
</body>
</html>