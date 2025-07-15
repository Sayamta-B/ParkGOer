<?php
    include '..\..\Forms\createConnection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $R_name=$_POST['R_name'];
        $Capacity=$_POST['Capacity'];
        $R_Price=$_POST['R_Price'];
        $ride_desc=$_POST['ride_desc'];
        
        if (isset($_FILES['ride_image']) && $_FILES['ride_image']['tmp_name'] != '') {
            // Get the file extension
            $imageFileType = strtolower(pathinfo($_FILES['ride_image']['name'], PATHINFO_EXTENSION));
        
            // Check if the uploaded file is an image
            $check = getimagesize($_FILES['ride_image']['tmp_name']);
        
            if ($check !== false) { // File is an image
                // Validate file type
                if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    // Validate file size (5MB limit)
                    if ($_FILES['ride_image']['size'] <= 5000000) {
                        // Image is valid, prepare it for storage
                        $imageData = file_get_contents($_FILES['ride_image']['tmp_name']);
                        $imageData = mysqli_real_escape_string($conn, $imageData);
                    } else {
                        // File size exceeds limit
                        echo "<script>
                                alert('Sorry, your file size exceeds the 5MB limit. Please try again!!');
                                window.location.href = 'rideSection.php?page=rideCreate';
                              </script>";
                        exit();
                    }
                } else {
                    // Invalid file type
                    echo "<script>
                            alert('Invalid image format. Only JPG, JPEG, and PNG files are allowed. Please try again!!');
                            window.location.href = 'rideSection.php?page=rideCreate';
                          </script>";
                    exit();
                }
            } else {
                // Not an image
                echo "<script>
                        alert('File is not a valid image. Please try again!!');
                        window.location.href = 'rideSection.php?page=rideCreate';
                      </script>";
                exit();
            }
        } else {
            // No file uploaded
            echo "<script>
                    alert('Image cannot be empty. Please upload an image. Please try again!!');
                    window.location.href = 'rideSection.php?page=rideCreate';
                  </script>";
            exit();
        }
        
        $sql = "INSERT INTO rides (R_name, Capacity, R_Price, ride_image, ride_desc)
            VALUES ('$R_name', '$Capacity', '$R_Price', '$imageData', '$ride_desc')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert ('Ride added successfully!!');
                    window.location.href = 'rideSection.php?page=rideList';
                  </script>";
            exit();
        } else {
            echo "Error adding ride: " . $conn->error;
        }
    }

    $conn->close();
?>