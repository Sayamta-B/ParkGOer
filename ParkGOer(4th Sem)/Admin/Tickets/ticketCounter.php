<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Counter</title>
    <link rel="stylesheet" href="../adminStylesheet.css">

    
</head>
<body>
    <div class="workingArea">
        <form action="usedStatus.php" method="POST" autocomplete="off">
        <fieldset>
            Ticket ID:<input type="number" name="ticketId" id="ticketId" required>
            <input type="submit" value="Entry" id="button" class="btn">
        </fieldset>
        </form>

        <?php
            include '../../Forms/createConnection.php'; // Include your database connection

            $sql = "SELECT R_id, R_name FROM rides"; 
            $result = $conn->query($sql);
        ?>

        <br/><br/><br/>
        <form action="removeRides.php" method="POST" autocomplete="off">
            <fieldset>
                Select Ride:
                <select name="rideId" id="rideId" required>
                    <option value="">-- Choose a Ride --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['R_id'] . "'>" . $row['R_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No rides available</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Empty Ride" id="button" class="btn">
            </fieldset>
        </form>
    </div>
</body>
</html>