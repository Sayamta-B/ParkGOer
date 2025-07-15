<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our rides</title>
    <link rel="stylesheet" href="userStylesheet.css">
</head>
<body>
    <?php
        include '../Forms/createConnection.php';

        $sql=$conn->prepare("SELECT t.T_id, t.is_Used, r.R_name, r.Status, r.Capacity
            FROM visitor AS v
            JOIN tickets AS t ON v.V_id= t.V_id
            JOIN rides AS r ON t.R_id=r.R_id
            WHERE v.V_id = ?;");
        $sql->bind_param("i", $_SESSION['V_id']);
        $sql->execute();
        $result=$sql->get_result();
        if($result->num_rows > 0){
        echo "<center><br/><br/><table border=1>
                <tr>
                    <th style='width:100px;'>Ticket ID</th>
                    <th style='width:200px;'>Ride Name</th>
                    <th style='width:160px;'>Status</th>
                    <th style='width:100px;'>Capacity</th>
                </tr>";

        // Loop through each row of the result set and output data
        while ($row = $result->fetch_assoc()) {
            $statusClass = ($row['is_Used'] == 1) ? 'usedTicket' : '';
            echo "<tr class='$statusClass'>
                    <td>{$row['T_id']}</td>
                    <td>{$row['R_name']}</td>
                    <td>" . ($row['Status'] == 'Available' ? 'Waiting' : 'In Motion') . "</td>
                    <td>{$row['Capacity']}</td>
                </tr>";
        }
        echo "</table></center>";
        } else {
        echo "<p>No rides available for this package.</p>";
        }
    ?>
</body>
</html>    