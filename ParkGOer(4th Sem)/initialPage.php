<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!--to include all symbols-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!--to make the website fit device screen-->
    <title>Initial Homepage</title>
    <link rel="icon" type="image/png" href="Photos/logo.png">
    <link rel="stylesheet" href="initialPage.css?v=1.0">
</head>
<body>
    <!-- Sticky header -->
    <?php
    include 'initialHeader.html';
    ?>

    <div class="videoHeader">
        <video autoplay muted loop>
            <source src="Photos/headerVideo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="initialWorkingArea">
        <a href="Forms/visitorLogin.php" title="Ticket Check in">
            <img src="Photos/ticketCheckIn.png" alt="Check-in with Ticket" 
            class="iconsInitial" style="border-radius=50px;">
        </a>

        <a href="our_Rides.php" title="Our rides">
            <img src="Photos/rides.png" alt="Check-in with Ticket" class="iconsInitial">
        </a>

    </div>

        <?php
        include 'initialFooter.html';
        ?>
    
    
</body>
</html>