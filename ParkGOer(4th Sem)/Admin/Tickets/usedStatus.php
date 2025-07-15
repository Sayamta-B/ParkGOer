<?php 
        session_start();
        //to embedded the php code of creating connection with database
        include '..\..\Forms\createConnection.php';
        define('BASE_URL', 'http://localhost/VMSproject');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $tick_id=$_POST['ticketId'];
            $sql = $conn->prepare("SELECT t.T_id, t.is_Used, r.R_id, r.R_name, t.V_id, r.Status, r.Capacity, r.currentUsed 
                                FROM Tickets AS t
                                JOIN Rides AS r ON t.R_id = r.R_id 
                                WHERE t.T_id = ?");
                            $sql->bind_param("i", $tick_id);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows === 0) {
                                echo "<script>
                                    alert('Error: Ticket does not exist.');
                                    window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                </script>";
                            }
                            

                            if ($row = $result->fetch_assoc()) {
                                if ($row['is_Used'] == 0) { // Ticket not used
                                    if (empty($row['V_id'])) {
                                        echo "<script>alert('Error: Ticket is not assigned to a visitor.')
                                                window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                            </script>";
                                    } else if ($row['Status'] == 'Unavailable') {
                                        echo "<script>
                                            alert('Error: Max Capacity Reached. Please wait.')
                                            window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                        </script>";
                                    }else {
                                        $newCurrent=$row['currentUsed']+1;
                                        // Assign ticket and update ride usage
                                        $sql1 = $conn->prepare("UPDATE Tickets SET is_Used =1 WHERE T_id = ?");
                                        $sql1->bind_param("i", $tick_id);
                                        if($sql1->execute()){
                                            echo "<script> 
                                                alert ('Ticket no. ".$row['T_id']." is assigned to ".$row['R_name']."');
                                                window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                                </script>";
                                        }

                                        $sql2 = $conn->prepare("UPDATE Rides 
                                                                SET currentUsed = ? 
                                                                WHERE R_id = ?");
                                        $sql2->bind_param("ii", $newCurrent, $row['R_id']);
                                        if($sql2->execute()){
                                            echo "<script> alert ('Current used updated of 'Ticket no. ".$row['T_id']."');</script>";
                                            if($newCurrent>=$row['Capacity']){
                                                $sql3 = $conn->prepare("UPDATE Rides 
                                                                        SET Status = 'Unavailable' 
                                                                        WHERE R_id = ?");
                                                $sql3->bind_param("i", $row['R_id']);
                                                if($sql3->execute()){
                                                    echo "<script> alert ('status updated');</script>";
                                            }
                                            }
                                        }

                                        echo"<script>
                                            window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                        </script>";
                                    }
                                } else {
                                    echo "<script>alert('Error: Ticket is already used.')
                                                window.location.href = '" . BASE_URL . "/Admin/Tickets/ticketSection.php?page=ticketCounter';
                                        </script>";
                                }
                            }
        }           
        else {
            echo "....................Something went wrong";
        }
    ?>