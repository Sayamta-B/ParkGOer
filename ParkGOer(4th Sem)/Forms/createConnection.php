<?php

$servername="localhost";//assigning servername
$username= "root";      //"root" for common users
$password= "";          //No password
$dbname= "parkgoer";   //assign database named "parkgoers"

$conn= new mysqli($servername, $username, $password, $dbname);
//Creating connection with existing database named "parkGOers"

if($conn!= true)
{
    die("Connection Failed.");
    //print string before exiting
}
?>