<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkGOer</title>
    <link rel="stylesheet" href="../adminStylesheet.css">
    <script>
        function validateRides(){
            var capacity= document.getElementById("Capacity").value.trim();
            var price= document.getElementById("R_Price").value.trim();

            if(capacity<0){
                alert("Capacity cannot be in negative");
                return false;
            }
            else if(price<0){
                alert("Price cannot be in negative");
                return false;
            }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <div class="workingArea">
        <form method="POST" action="addRide.php" enctype="multipart/form-data" onsubmit="return validateRides()">
            <fieldset>
            <h1>Create Rides</h1><br/>
                Ride Name: <input type="text" name="R_name" id="R_name">
                Ride Capacity: <input type="number" name="Capacity" id="Capacity">
                Ride Price: <input type="number" name="R_Price" id="R_Price">
                Ride Image: <input type="file" name="ride_image" required>
                Ride Description: <textarea name="ride_desc" id="ride_desc"></textarea>
                <input type="submit" value="Add" class="btn">
            </fieldset>
        </form>
    </div>
</body>
</html>