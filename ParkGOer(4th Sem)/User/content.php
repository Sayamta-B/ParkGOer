<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select rides</title>
    <!-- <link rel="stylesheet" href="userStylesheet.css"> -->
</head>
<body>
    <div class="workingAreaUser">
        <div class="secondHorizontalNavBar">
            <ul>
                <li class="horizElements <?php echo (isset($_GET['page']) &&  $_GET['page'] == 'tableSelectRide') ? 'active' : ''; ?>">
                    <a href="?page=tableSelectRide" title="Select Rides" >Select Rides</a>
                </li>
                <li class="horizElements <?php echo (isset($_GET['page']) &&  $_GET['page'] == 'visitorInfo') ? 'active' : ''; ?>">
                    <a href="?page=visitorInfo" title="Tickets">Your Tickets</a>
                </li>
                <li class="horizElements <?php echo (isset($_GET['page']) &&  $_GET['page'] == 'ourRides') ? 'active' : ''; ?>">
                    <a href="?page=ourRides" title="Our rides">Our Rides</a>
                </li>               
            </ul>
        </div><br/>
    </div>
    <?php
            // Load the selected page dynamically
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page === 'tableSelectRide') {
                    include 'tableSelectRide.php';
                } elseif ($page === 'visitorInfo') {
                    include 'visitorInfo.php';
                }elseif ($page === 'ourRides') {
                    include 'ourRides.php';
                } else {
                    echo "<p>Page not found.</p>";
                }
            } else {
                include 'tableSelectRide.php';
            }
    ?>
</body>
</html>