<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rides</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
</head>
<body>
    <div class="workingArea" style="margin-top: 0;">
    <?php 
        include '../Forms/createConnection.php';

        // Query to fetch ride details
        $sql = "SELECT * FROM rides";
        $result = $conn->query($sql);

        // Check if the result contains rows
        if ($result && $result->num_rows > 0) {
            echo "<table >";

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
                        </tr>
                        <tr>
                        <td colspan=2>Status: {$row['Status']}</td>
                        </tr>
                        <tr>
                        <td colspan=2>Capacity: {$row['Capacity']}</td>
                        </tr>
                        <tr>
                        <td colspan=2>Price: Rs. {$row['R_Price']}</td>
                        </tr>
                        <tr>
                        <td colspan=2>Ticket available: {$row['ticketAvailable']}</td>
                        </tr>
                        <tr>
                        <td colspan=2>{$row['ride_desc']}</td>
                        </tr>
                        <tr>
                        <td style='height: 50px;' colspan=2> </td>
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
