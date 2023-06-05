<?php
// start the session
session_start();

// check if user is logged in
if (!isset($_SESSION["user_id"])) {
  echo "<div style=\"background-color: #f2f2f2; padding: 20px; border: 1px solid #ccc; border-radius: 5px; text-align: center;\">";
  echo "<p style=\"font-size: 24px; color: #333;\">You have not logged in.</p>";
  echo "<a href=\"login.html?redirect=true\" style=\"display: inline-block; background-color: #333; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 16px;\">Click here to go to the login page</a>";

  echo "</div>";
    
  exit();
}

// retrieve user ID from session
$user_id = $_SESSION["user_id"];

// connect to the database
$conn = mysqli_connect("localhost", "root", "", "rentit");

// check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// prepare SQL statement to retrieve ordered items
$sql = "SELECT * FROM orders WHERE user_id = $user_id";

// execute SQL statement
$result = mysqli_query($conn, $sql);

// check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  echo "<h1>Ordered Items</h1>";
  echo "<table>";
  echo "<tr><th>Product Name</th><th>Quantity</th></tr>";

  // iterate over the ordered items
  while ($row = mysqli_fetch_assoc($result)) {
    $product_name = $row["product_name"];
    $quantity = $row["quantity"];

    echo "<tr><td>$product_name</td><td>$quantity</td></tr>";
  }

  echo "</table>";
} else {
  echo "<p>No ordered items found.</p>";
}

// close connection
mysqli_close($conn);
?>
