<?php
    //to embedded the php code of creating connection with database
    include 'C:\xampp\htdocs\VMSproject\createConnection.php';

    $sql='SELECT Password FROM admin WHERE Username="kjhgfdswert";';
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            echo "id: " . $row["Password"]. "<br>";
        }
    }

?>