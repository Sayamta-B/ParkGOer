<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Homepage</title>
    <link rel="stylesheet" href="userStylesheet.css?v=1.4">
</head>

<body>
<div class="header">
        
        <img src="..\Photos\logo.png" alt="parkGOer Logo" class="logoImg">
        <button style="background-color: orangered; margin-left: 1100px; margin-top: 10px; border-radius:15px;" 
        onclick="window.location.href='../Forms/visitorLogOut.php';">Log Out</button>
    </div>        


    <div class="videoHeader">
        <video autoplay muted loop>
            <source src="../Photos/headerVideo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</body>
</html>