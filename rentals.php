<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rentals - Rent It</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Rent It</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php"><img src="photos/demo-home.webp" alt="Home" class="profile-icon" title="Home"> </a></li>                    
                    <li><a href="contact.php"><img src="photos/demo-contact.jpg" alt="Contact Us" class="profile-icon" title="Contact Us"></a></li>
                    <li><a href="cart.php"><img src="photos/demo-cart.webp" alt="My Cart" class="profile-icon" title="My Cart"></a></li>
                    <li><a href="myprofile.php"><img src="<?php echo $profile_picture_path; ?>" alt="My Profile" class="profile-icon" title="My Profile"></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="rentals-page">
    <div class="container">
        <h2>Available Rentals</h2>
        
        <?php
        // Connect to your database
        $conn = mysqli_connect("localhost", "root", "", "rentit");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare SQL statement to retrieve rental data
        $sql = "SELECT * FROM rentals";
        $result = mysqli_query($conn, $sql);

        // Check if any rentals were found
        if (mysqli_num_rows($result) > 0) {
            // Loop through each rental and display its information
            while ($row = mysqli_fetch_assoc($result)) {
                $rentalName = $row["name"];
                $rentalDescription = $row["description"];
                $rentalImage = $row["image_path"];

              // Display the rental listing
echo '<div class="rental-item">';
echo '<img src="' . $rentalImage . '" alt="' . $rentalName . '" class="rental-image">';
echo '<div class="rental-details">';
echo '<h3 class="rental-name">' . $rentalName . '</h3>';
echo '<p class="rental-description">' . $rentalDescription . '</p>';
echo '<a href="#" class="btn">Rent Now</a>';
echo '</div>';
echo '</div>';

            }
        } else {
            // No rentals found
            echo '<p>No rentals available at the moment.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        
    </div>
</section>

    <footer>
        <div class="container">
            <p>&copy; 2023 Rent It</p>
        </div>
    </footer>
</body>
</html>
