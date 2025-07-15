<?php 
    session_start();
    include '../Forms/createConnection.php';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $total=0;
        // Fetch ride data and ticket availability
        $sql = "SELECT R_id, R_name, R_Price, ticketAvailable FROM rides";
        $result = $conn->query($sql);
        $ticketAvailability = []; // Array to store tickets available

        echo "<center><h1>Ride Bill</h1></center>";
        echo "<table border='1' style='width: 50%; margin: auto; border-collapse: collapse;'>
            <tr>
                <th>Ride Name</th>
                <th>Price (Rs.)</th>
                <th>Quantity</th>
                <th>Subtotal (Rs.)</th>
            </tr>";
        // Loop through each ride
        while ($row = $result->fetch_assoc()) {
            // Store available tickets for each ride
            $ticketAvailability[$row['R_id']]= $row['ticketAvailable'];

            // Get the number of tickets selected by the user for this ride
            $ticket_byUser = $_POST['hiddenCount' . $row['R_id']];

            // Calculate the new ticket availability
            $newAvailable = $ticketAvailability[$row['R_id']] - $ticket_byUser;            
            
            //Select certain(limit) T_id from tickets where R_id is given and V_id is NUll
            $sqlSelectTicketID = $conn->prepare("SELECT T_id FROM tickets WHERE R_id = ? AND V_id IS NULL LIMIT ".$ticket_byUser);
            $sqlSelectTicketID->bind_param("i", $row['R_id']);
            $sqlSelectTicketID->execute();
            $ticketResult = $sqlSelectTicketID->get_result();

            while ($ticketRow = $ticketResult->fetch_assoc()) {
                //echo "yayyyy Ticket id".$ticketRow['T_id'];
                $ticketID = $ticketRow['T_id'];
                $sqlUpdateRides = $conn->prepare("UPDATE tickets SET V_id = ? WHERE T_id = ?");
                $sqlUpdateRides->bind_param("ii", $_SESSION['V_id'], $ticketID);
                if ($sqlUpdateRides->execute()) {
                    echo ".";

                } else {
                    echo "Error updating V_id: " . $conn->error . "<br>";
                }
            }

            // Update the available tickets in the database for the current ride
            $sqlUpdateTickets = $conn->prepare("UPDATE rides SET ticketAvailable = ? WHERE R_id = ?");
            $sqlUpdateTickets->bind_param("ii", $newAvailable, $row['R_id']);

            if($sqlUpdateTickets->execute()){
                //echo "Sucessfully updated";
            }
            else{
                echo "Error: " . $conn->error;
            }
            $subtotal=$row['R_Price']*$ticket_byUser;
            $total+=$subtotal;

            if($ticket_byUser>0){
                echo "<tr>
                    <td>".$row['R_name']."</td>
                    <td>".$row['R_Price']."</td>
                    <td>".$ticket_byUser."</td>
                    <td>".$subtotal."</td>
                </tr>";
            }
        }
        echo"<tr>
            <td colspan='3'><strong>Total</strong></td>
            <td> Rs.".$total."</td>
        </tr>";
    }

    $conn->close();
?>