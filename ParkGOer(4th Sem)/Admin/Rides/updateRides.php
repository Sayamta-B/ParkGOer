<?php
session_start();
include "../../Forms/createConnection.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $R_id=$_POST['rideId'];
    $Capacity=$_POST['Capacity'];
    $R_Price=$_POST['R_Price'];
    $ride_desc=$_POST['ride_desc'];

    $sqlUpdate = $conn->prepare("Update rides SET Capacity=?, R_Price=?, ride_desc=? WHERE R_id=?;");
    $sqlUpdate->bind_param("iisi", $Capacity, $R_Price, $ride_desc, $R_id);
        if ($sqlUpdate->execute()) {
            echo "<script>
                    alert ('Ride updated successfully!!');
                    window.location.href = 'rideSection.php?page=rideList';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Failed to update ticket. Please try again.');
                    window.location.href = 'rideSection.php?page=rideList';
                </script>";
        }
    }

    $conn->close();
?>