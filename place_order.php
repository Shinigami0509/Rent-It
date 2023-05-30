<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  // User not logged in
  $response = array(
    'success' => false,
    'message' => 'User not logged in.'
  );
  echo json_encode($response);
  exit();
}

$user_id = $_SESSION["user_id"];
$fullname = '';
$phone = '';
$address = $_POST['address'];
$voucher = $_POST['voucher'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "rentit");


$sql = "SELECT * FROM users WHERE id = $user_id";

// execute SQL statement
$result = mysqli_query($conn, $sql);

// check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // retrieve user data
    $row = mysqli_fetch_assoc($result);
    $name = $row["fullname"];    
    $phone = $row["phone"];  
} else {
    // user not found
    echo "User not found.";
    exit();
}

// Check connection
if (!$conn) {
  $response = array(
    'success' => false,
    'message' => 'Database connection error.'
  );
  echo json_encode($response);
  exit();
}

// Get fullname and phone from the users table
$getUserDataQuery = "SELECT fullname, phone FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $getUserDataQuery);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $fullname = $row['fullname'];
  $phone = $row['phone'];
} else {
  $response = array(
    'success' => false,
    'message' => 'Failed to retrieve user data from the users table.'
  );
  echo json_encode($response);
  exit();
}

// Prepare the update query
$updateQuery = "UPDATE users SET address = '$address' WHERE id = '$user_id'";

// Execute the update query
if (mysqli_query($conn, $updateQuery)) {
  // Save the order to the orders table
  $saveOrderQuery = "INSERT INTO orders (user_id, fullname, address, phone, voucher) VALUES ('$user_id', '$fullname', '$address', '$phone', '$voucher')";

  if (mysqli_query($conn, $saveOrderQuery)) {
    // Delete rented items from rented_items table for the user
    $deleteRentedItemsQuery = "DELETE FROM rented_items WHERE user_id = '$user_id'";
    mysqli_query($conn, $deleteRentedItemsQuery);

    $response = array(
      'success' => true,
      'message' => 'User details updated successfully and order saved.'
    );
  } else {
    $response = array(
      'success' => false,
      'message' => 'Failed to save order.'
    );
  }
} else {
  $response = array(
    'success' => false,
    'message' => 'Failed to update user details.'
  );
}

// Close the database connection
mysqli_close($conn);

echo json_encode($response);
?>
