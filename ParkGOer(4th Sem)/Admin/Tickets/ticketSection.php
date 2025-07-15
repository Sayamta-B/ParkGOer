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
                <a href="http://localhost/VMSproject/Admin/Tickets/ticketSection.php" class="NavElements active">Ticket</a>
            </li>
            <li class="NavElements">
                <a href="http://localhost/VMSproject/Admin/Rides/rideSection.php" class="NavElements">Ride</a>
            </li>
        </ul>
    </div>
    <?php
        if (!isset($_GET['page'])) {
            $_GET['page'] = 'ticketCreation';  // Set default to 'ticketCreation'
        }
    ?>
    <div class="header">
        <img src="..\..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">

        <nav class="horizontalNavBar">
            <ul>
                <li class="horizNavElements">
                    <a href="?page=ticketCreation" class="horizNavElements <?php echo (isset($_GET['page']) &&  $_GET['page'] == 'ticketCreation') ? 'active' : ''; ?>">Ticket Creation</a>
                </li>
                <li class="horizNavElements">
                    <a href="?page=ticketList" class="horizNavElements <?php echo (isset($_GET['page']) && $_GET['page'] == 'ticketList') ? "active" : "" ;?>">Ticket List</a>
                </li>
                <li class="horizNavElements">
                    <a href="?page=ticketCounter" class="horizNavElements <?php echo (isset($_GET['page']) && $_GET['page'] == 'ticketCounter') ? "active" : "" ;?>">Ticket Counter</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php
            // Load the selected page dynamically
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page === 'ticketCreation') {
                    include 'ticketCreation.php';
                } elseif ($page === 'ticketList') {
                    include 'ticketList.php';
                } else if($page=='ticketCounter'){
                    include 'ticketCounter.php';
                }else {
                    include 'ticketCreation.php';
                }
            }else{
                echo "Something went wrong";
            }
    ?>
</body>
</html>