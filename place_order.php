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
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$voucher = $_POST['voucher'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "rentit");

// Check connection
if (!$conn) {
  $response = array(
    'success' => false,
    'message' => 'Database connection error.'
  );
  echo json_encode($response);
  exit();
}

// Prepare the update query
$updateQuery = "UPDATE users SET";
$updateFields = array();

// Check if each field is edited and add it to the update query
if (!empty($name)) {
  $updateFields[] = "name = '$name'";
}
if (!empty($address)) {
  $updateFields[] = "address = '$address'";
}
if (!empty($phone)) {
  $updateFields[] = "phone = '$phone'";
}
if (!empty($voucher)) {
  $updateFields[] = "voucher = '$voucher'";
}

// Check if any fields are edited
if (!empty($updateFields)) {
  $updateQuery .= " " . implode(", ", $updateFields);
  $updateQuery .= " WHERE id = '$user_id'";

  // Execute the update query
  if (mysqli_query($conn, $updateQuery)) {
    $response = array(
      'success' => true,
      'message' => 'User details updated successfully.'
    );
  } else {
    $response = array(
      'success' => false,
      'message' => 'Failed to update user details.'
    );
  }
} else {
  $response = array(
    'success' => false,
    'message' => 'No fields are edited.'
  );
}

// Close the database connection
mysqli_close($conn);

echo json_encode($response);