<?php 
    include '../Forms/createConnection.php';

    $sql = "SELECT R_id, ticketAvailable FROM Rides";
    $result = $conn->query($sql);
    $ticketAvailability = [];//array to store tickets available
    while ($row = $result->fetch_assoc()) {
        $ticketAvailability[$row['R_id']] = $row['ticketAvailable'];
    }
    $conn->close();
?>


    <script>
        var ticketAvailability = <?php echo json_encode($ticketAvailability); ?>;
        var counts={};
        function sub(id) {
            if (!counts[id]){
                counts[id] = 0;
            }
            var availableTickets = ticketAvailability[id]; // Get preloaded count
            if (counts[id]>0) {
                counts[id]--;
                document.getElementById("rideNumber"+id).innerHTML = counts[id];
                document.getElementById("hiddenCount"+id).value = counts[id]; 
            }
        }

        function add(id) {
            if (!counts[id]){
                counts[id] = 0;
            }
            var availableTickets = ticketAvailability[id]; // Get preloaded count
            if (counts[id]<availableTickets) {
                counts[id]++;
                document.getElementById("rideNumber"+id).innerHTML = counts[id];
                document.getElementById("hiddenCount"+id).value = counts[id];
            } else {
                alert("No tickets available.");
            }
        }
    </script>