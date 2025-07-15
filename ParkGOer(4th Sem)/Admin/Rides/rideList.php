<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rides</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
    <script>
        function confirmDelete(rideId) {
            const confirmAction = confirm("Are you sure you want to delete Ride ID " + rideId + "?");
            if (confirmAction) {
                // Proceed with deletion
                window.location.href = 'deleteRide.php?id=' + rideId;
            }
        }
    </script>
</head>
<body>
    <div class="workingArea" style="margin-top: 0;">
    <?php 
        include '../../Forms/createConnection.php';

        // Query to fetch ride details
        $sql = "SELECT * FROM rides";
        $result = $conn->query($sql);

        // Check if the result contains rows
        if ($result && $result->num_rows > 0) {
            echo "<table border='1' cellspacing='0' cellpadding='5'>
			<th>Ride</th>
			<th style='width:400px;'>Ride Name</th>
			<th>Status</th>
			<th>Capacity</th>
			<th style='width:160px;'>Price</th>
			<th>Tickets Available</th>
			<th>Ride Description</th>
			<th>Actions</th>";

            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                         <td style='width: 160px;'>";
                         if (!empty($row['ride_image'])) {
                            // Display the image
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['ride_image']) . "' 
                                style='max-width: 150px; max-height: 150px; border-radius: 8px;'/>";
                        } else {
                            echo "<p>No image available for this ride.</p>";
                        }                                              
                        echo"</td>
                        <td>{$row['R_name']}</td>
                        <td>{$row['Status']}</td>
                        <td>{$row['Capacity']}</td>
                        <td>Rs. {$row['R_Price']}</td>
                        <td>{$row['ticketAvailable']}</td>
                        <td><textarea style='width:240px; height:200px; background:lightYellow;'>{$row['ride_desc']}</textarea></td>
                        <td>
                            <a href='updateRideForm.php?id={$row['R_id']}'>Update</a> |
                            <a href='#' onclick='confirmDelete(\"{$row['R_id']}\")'>Delete</a>
                        </td>
                        </tr>";
            }

            echo "</table>";}
             else {
            echo "<p>No rides found in the database.</p>";
        }

        $conn->close();
    ?>
    </div>
</body>
</html>
