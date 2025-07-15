<?php 
    $servername="localhost";//assigning servername
    $username= "root";      //"root" for common users
    $password= "";          //No password
    
    $conn= new mysqli($servername, $username, $password);

    $sql="CREATE DATABASE parkgoer";
    if($conn->query($sql)){
        echo "Database Created Sucessfully";
    }
    else{
        echo "Failed to create database";
    }
?>