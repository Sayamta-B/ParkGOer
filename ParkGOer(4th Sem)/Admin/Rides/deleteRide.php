<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkGOer</title>
</head>
<body>
    <?php
        session_start();
        define('BASE_URL', 'http://localhost/VMSproject/');
        include "../../Forms/createConnection.php";

        // Check if the 'id' parameter is set
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $checkTickets = $conn->prepare("SELECT currentUsed FROM Rides WHERE R_id = ?");
            $checkTickets->bind_param("i", $id);
            $checkTickets->execute();
            $result = $checkTickets->get_result();
            $row = $result->fetch_assoc();

            if ($row && $row['currentUsed'] > 0) {
                echo "<script>
                    alert('Update failed! Tickets are still available for this ride.');
                    window.location.href = '" . BASE_URL . "Admin/Rides/rideSection.php?page=rideList';
                </script>";
            } 
            else{
            //Delete all tickets of the ride
            $sqldelTickets = $conn->prepare("DELETE FROM Tickets WHERE R_id = ?");
            $sqldelTickets->bind_param("i", $id);
            if ($sqldelTickets->execute()) {
                echo "<script>
                    alert('Tickets of rides deleted successfully.');
                    </script>";
            }

            // Prepare and execute the delete query
            $sql = $conn->prepare("DELETE FROM Rides WHERE R_id = ?");
            $sql->bind_param("i", $id);

            if ($sql->execute()) {
                echo "<script>
                    alert('Ride deleted successfully.');
                    window.location.href = 'rideSection.php?page=rideList';
                    </script>";                    
            }
             else {
                echo "<script>
                    alert('Failed to delete ticket. Please try again.');
                    window.location.href = 'rideSection.php?page=rideList';
                </script>";
           }
        }}
        else {
            echo "<script>alert('Invalid request.');</script>";
        }
    ?>
</body>
</html>
