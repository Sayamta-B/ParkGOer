<?php

include 'createConnection.php';

//create table for Visitor
$sql="CREATE TABLE Visitor(
    V_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    V_username VARCHAR(100) UNIQUE,
    V_email VARCHAR(100) UNIQUE,
    V_password VARCHAR(100)
);";

//create table for admin
$sql.="CREATE TABLE Admin(
    A_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    A_name VARCHAR(100),
    DOB VARCHAR(60),
    Email VARCHAR(60),
    Phone_no VARCHAR(15),
    Username VARCHAR(60) UNIQUE,
    Password VARCHAR(100)
);";

//create table for rides
$sql.="CREATE TABLE Rides(
    R_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    R_name VARCHAR(100),
    Status VARCHAR(200) DEFAULT 'Available',
    Capacity INT(10) NOT NULL DEFAULT 0,
    currentUsed INT(10) NOT NULL DEFAULT 0,       //used to compare with capacity to knoe if ride is full
    R_Price INT(20),
    ticketAvailable INT(50) DEFAULT 0,             //how many tickets aren't already sold
    ride_image LONGBLOB,
    ride_desc TEXT 
);";

//create table for tickets
$sql.="CREATE TABLE Tickets(
    T_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    Date VARCHAR(60),
    T_Price INT(20),
    is_Used VARCHAR(20) DEFAULT false,          //flag to indicate used or unused
    V_id INT(10),
    A_id INT(10),
    R_id INT(10),
    FOREIGN KEY (V_id) REFERENCES Visitor(V_id),
    FOREIGN KEY (A_id) REFERENCES Admin(A_id),
    FOREIGN KEY (R_id) REFERENCES Rides(R_id)
);";

if($conn->multi_query($sql)){
    echo "Table Created Sucessfully";
}
else{
    echo "Error creating tables: " . $conn->error;
}
?>