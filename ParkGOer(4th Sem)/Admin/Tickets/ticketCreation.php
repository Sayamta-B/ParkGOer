<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="../adminStylesheet.css">    
</head>
<body>
    <div class="workingArea">
        <form action="insertCreatedTickets.php" method="post" autocomplete="off">
            <fieldset>
            <h1>Create Ticket</h1>
                <?php
                    //to embedded the php code of creating connection with database
                    include '..\..\Forms\createConnection.php';

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql=$conn->prepare("SELECT R_id, R_name FROM Rides;");
                    $sql->execute();
                    $result=$sql->get_result();

                    if ($result->num_rows > 0) {
                    echo 'Ride name:';
                    echo '<select name="rideId" id="rideId">';
                    while ($row = $result->fetch_assoc()) {
                        // Use ride name as the visible option and ride ID as the value
                        echo '<option value="' . htmlspecialchars($row['R_id']) . '">' . htmlspecialchars($row['R_name']) . '</option>';
                    }
                    echo '</select>';
                    } else {
                    echo 'No rides found.';
                    }
                ?>

                <br/>Creation Quantity:
                <input type="number" name="creationQty" id="creationQty">

                <div class="button"><input type="submit" value="Create" id="button" class="btn"></div>
            </fieldset>
        </form>
    </div>
</body>
</html>