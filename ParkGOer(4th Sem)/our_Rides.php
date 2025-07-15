<?php 
    include 'Forms\createConnection.php';

    // Query to fetch ride images
    $sql = "SELECT * FROM rides";
    $result = $conn->query($sql);

    // Check if the result contains rows
    if ($result && $result->num_rows > 0) {
        // Loop through the results
        while ($row = $result->fetch_assoc()) {
            echo "<div class=workingArea>";
            echo "<div style='display:block; justify-content:center; border:1px solid black; background-color:lightskyblue; width:600px; margin:20px; padding:20px;'>";
            echo "<div class=mid>";    
            // Ensure ride_image is not null
                if (!empty($row['ride_image'])) {
                    // Display the image
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['ride_image']) . "' 
                    style='max-width: 150px; max-height: 150px; border-radius:8px; margin:50px; margin-left:0'/>";
                } else {
                    echo "<p>No image available for this ride.</p>";
                }
                echo "<br/>";
                echo "Ride name: " .$row["R_name"]."<br/>";
                echo "Ride Status: " . $row["Status"]."<br/>";
                echo "Ride Capacity: " . $row["Capacity"]."<br/>";
                echo "Ride ticket used: " . $row["currentUsed"]."<br/>";
                echo "Ride price: " . $row["R_Price"]."<br/>";
                echo "Ride Tickets Available: " .$row["ticketAvailable"]."<br/>";
            echo "</div>";
                echo "Ride description: " . $row['ride_desc'];
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No rides found in the database.</p>";
    }

    $conn->close();
?>
