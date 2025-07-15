<?php 
        session_start();
        define('BASE_URL', 'http://localhost/VMSproject/');
        //to embedded the php code of creating connection with database
        include '..\..\Forms\createConnection.php';
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if($_SERVER['REQUEST_METHOD']=="POST"){
            $rideId=$_POST['rideId'];         
            // Prepare and execute the delete query
                $sql = $conn->prepare("UPDATE Rides SET Status = 'Available', currentUsed=0 WHERE R_id = ?");
                $sql->bind_param("i", $rideId);

                    if ($sql->execute()) {
                        echo "<script>
                            alert('Avaibility successful.');
                            window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php?page=ticketCounter';
                            </script>";
                            
                    }
                    else {
                        echo "<script>
                            alert('Failed to update rides. Please try again.');
                            window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php?page=ticketCounter';
                </script>";
                }}  
            else {
                echo "<script>alert('Invalid request.');
                window.location.href = '" . BASE_URL . "Admin/Tickets/ticketSection.php?page=ticketCounter';
                </script>";
            }
?>