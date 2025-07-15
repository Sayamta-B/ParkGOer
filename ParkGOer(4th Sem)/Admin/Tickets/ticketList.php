<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket Information</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
    <script>
        function confirmDelete(ticketId) {
            const confirmAction = confirm("Are you sure you want to delete Ticket ID " + ticketId + "?");
            if (confirmAction) {
                // Proceed with deletion
                window.location.href = 'deleteTicket.php?id=' + ticketId;
            }
        }
    </script>
</head>
<body>
    <div class="workingArea">
    <?php
        include '../../Forms/createConnection.php';

        $sql=$conn->prepare("SELECT t.*, r.R_name FROM tickets AS t JOIN rides AS r
                            ON t.R_id=r.R_id;");
        $sql->execute();
        $result=$sql->get_result();
        if($result->num_rows > 0){
        echo "<table border=1 cellspacing='0' cellpadding='5'>
                <tr>
                    <th>Ticket ID</th>
                    <th style='width:200px;'>Ride Name</th>
                    <th style='width:160px;'>Ticket Date</th>
                    <th>Ticket Price</th>
                    <th>Visitor ID</th>
                    <th>Admin ID</th>
                    <th style='width:80px;'>Edit</th>
                </tr>";

        // Loop through each row of the result set and output data
        while ($row = $result->fetch_assoc()) {
            //check status
            $statusClass = ($row['is_Used'] == 1) ? 'usedTicket' : '';
            echo "<tr class='$statusClass'>
                    <td>{$row['T_id']}</td>
                    <td>{$row['R_name']}</td>
                    <td>{$row['Date']}</td>
                    <td>{$row['T_Price']}</td>
                    <td>{$row['V_id']}</td>
                    <td>{$row['A_id']}</td>
                    <td>

                    <a href='#' onclick='confirmDelete(\"{$row['T_id']}\")'>
                        Delete
                        </a>
                    </td>
                </tr>";
        }
        echo "</table>";
        }
        else{
            echo "No Tickets Available...";
        }
    ?>
    </div>
    
</body>
</html>