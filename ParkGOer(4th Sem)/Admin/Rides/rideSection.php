<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
    
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
    <?php
        if (!isset($_GET['page'])) {
            $_GET['page'] = 'rideList';  // Set default to 'rideList'
        }
    ?>
    <div class="header">
        <img src="..\..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">

        <nav class="horizontalNavBar">
            <ul>
                <li class="horizNavElements">
                    <a href="?page=rideList" class="horizNavElements <?php echo (isset($_GET['page']) &&  $_GET['page'] == 'rideList') ? 'active' : ''; ?>">Ride List</a>
                </li>
                <li class="horizNavElements">
                    <a href="?page=rideCreate" class="horizNavElements <?php echo (isset($_GET['page']) && $_GET['page'] == 'rideCreate') ? "active" : "" ;?>">Ride Creation</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php
        // Load the selected page dynamically
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page === 'rideList') {
                include 'rideList.php';
            } elseif ($page === 'rideCreate') {
                include 'rideForm.php';
            } else {
                include 'rideList.php';
            }
        }else{
            echo "Something went wrong";
        }
    ?>
</body>
</html>