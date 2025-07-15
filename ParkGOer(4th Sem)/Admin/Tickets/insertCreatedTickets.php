<?php
    session_start();
    define('BASE_URL', 'http://localhost/VMSproject/');
    //to embedded the php code of creating connection with database
    include '..\..\Forms\createConnection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if($_SERVER['REQUEST_METHOD']=="POST"){
        

        $rideID=$_POST['rideId'];

        if (!empty($rideID)) {
            $sql=$conn->prepare("SELECT R_Price, ticketAvailable FROM Rides WHERE R_id = ?");
            $sql->bind_param("i", $rideID); // 'i' for integer
            $sql->execute();
            $result=$sql->get_result();

            if ($result->num_rows > 0) {
                // Fetch the price
                $row = $result->fetch_assoc();
                $ticketPrice = $row['R_Price']; // Get the ride price
                $availableTickets=$row['ticketAvailable'];
    
                $createQty = $_POST['creationQty'];
                $ticketDate = date('Y-m-d');
    
                while ($createQty > 0) {
                    // Insert the ticket with the retrieved price
                    $sqlInsert = $conn->prepare("INSERT INTO Tickets (Date, T_Price, A_id, R_id) VALUES (?, ?, ?, ?)");
                    $sqlInsert->bind_param("siii", $ticketDate, $ticketPrice, $_SESSION['A_id'], $rideID); 
                    $sqlInsert->execute();
    
                    $createQty--; // Decrement the quantity
                }

                $new_availableTickets=$availableTickets+ $_POST['creationQty'];
                $sqlUpdate=$conn->prepare("UPDATE rides SET ticketAvailable=? WHERE R_id=?");
                $sqlUpdate->bind_param("ii", $new_availableTickets, $rideID);
                $sqlUpdate->execute();
                echo "<script>alert('Creation Sucessful!');
                    window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php';
                </script>";
            } else {
                echo "No price found for the selected ride.";
            }
        } else {
            echo "No ride type selected!";
        }
    }
        
    $conn->close();      
?>