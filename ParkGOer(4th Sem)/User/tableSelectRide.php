<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Rides</title>

    <?php
        include 'addMinusTickets.php';
        // Include the database connection
        include '../Forms/createConnection.php';

        // Fetch rides from the database
        $sql = "SELECT * FROM Rides"; // Only show available rides
        $result = $conn->query($sql);
    ?>
</head>
<body>
    <div class="content">
        <div class="container">
            <h1>Select Your ParkGOer Rides</h1>
            <form method="POST" action="updateRideTicket.php">
                <?php
                // Check if there are any rides to display
                if ($result->num_rows > 0) {
                    // Loop through each ride and display it
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="box">';
                        echo '<ul class="ticketBox">';
                        if (!empty($row['ride_image'])) {
                            // Display the image
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['ride_image']) . "' 
                            style='max-width: 70px; max-height:70px; border-radius:8px; margin-top:5px; margin-bottom:0;'/>";
                        } else {
                            echo "<p>No image available for this ride.</p>";
                        }
                        echo '<li id="rideName">' . $row['R_name'] . '</li>'; // Ride name
                        echo '<li>Rs. ' . $row['R_Price'] . '</li>'; // Ride price
                        echo '<li>';
                        echo '<div class="addMinus">';
                        echo '<input type="button" onclick="sub(' .$row['R_id'] . ')" class="addMinusBtn" value="-">';
                        echo '<input type="hidden" name="hiddenCount' .$row['R_id'] . '" id="hiddenCount' .$row['R_id'] . '" value="0">';
                        echo '<div class="noOfTicket"><p id="rideNumber' . $row['R_id'] . '">0</p></div>';
                        echo '<input type="button" onclick="add(' .$row['R_id'] . ')" class="addMinusBtn" value="+">';
                        echo '</div>';
                        echo '</li>';
                        echo '</ul>';
                        echo '</div>';
                    }
                } else {
                    echo "No rides available.";
                }
                ?>
                
                <input type="submit" value="Select" class="button" style="margin-left:370px">
            </form>
            </div>
    </div>
</body>
</html>
