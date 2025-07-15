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
        include "../../Forms/createConnection.php";
        define('BASE_URL', 'http://localhost/VMSproject/');

        // Check if the 'id' parameter is set
        if (isset($_GET['id'])) {
            $id = $_GET['id'];          
            // Prepare and execute the update query
            $sqlMinus = $conn->prepare("UPDATE Rides
                                            SET ticketAvailable = ticketAvailable - 1
                                            WHERE R_id = (SELECT R_id FROM Tickets WHERE T_id = ?)
                                            AND ticketAvailable > 0");
            $sqlMinus->bind_param("i", $id);

            if ($sqlMinus->execute()) {
                //to decrease ticket count if deleted the ticket
                $sqlDel = $conn->prepare("DELETE FROM Tickets WHERE T_id = ?");
                $sqlDel->bind_param("i", $id);
                if($sqlDel->execute()){
                    echo "<script>
                            alert('Ticket deleted successfully.');
                    </script>";
                    echo "<script>
                    alert('Ticket availability decreased successfully.');
                    window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php?page=ticketList';
                    </script>";
                    exit();
                }                    
            }
             else {
                echo "<script>
                    alert('Failed to delete ticket. Please try again.');
                    window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php?page=ticketList';
           </script>";
           }
        }   
        else {
            echo "<script>alert('Invalid request.');</script>";
        }
    ?>
</body>
</html>
