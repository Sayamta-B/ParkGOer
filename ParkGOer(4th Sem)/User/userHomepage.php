<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Homepage</title>
    <link rel="stylesheet" href="userStylesheet.css">
</head>

<body>
        <?php
            session_start();
            include 'userHeader.php';
        ?>

    <div class="contentandFAQ">
    <div class="content">
        <?php
            include 'content.php';
        ?>
    </div>

    <div class="rightFAQ">
        <h1>FAQs</h1><br/>
    1. What are the park's opening and closing hours?<br/>
    ->Our park is open daily from 10:00 AM to 8:00 PM. Special holiday hours may apply.<br/><br/>

    2. Where is the park located?<br/>
    ->We are located at Kathmandu.<br/><br/>

    3. How much do tickets cost?<br/>
    ->Ticket prices vary based on the type of ride you choose. For detailed pricing, please visit our select rides.<br/><br/>

    <center>Please contact the staff counter for further queries.</center>


    </div>
    </div>

    <?php
    include 'userFooter.html';
    ?>
</body>
</html>