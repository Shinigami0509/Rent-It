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
$conn = mysqli_connect("localhost", "root", "", "rentit");

if (!$conn) {
  $response = array(
    'success' => false,
    'message' => 'Failed to connect to the database.'
  );
  echo json_encode($response);
  exit();
}

$sql = "SELECT rental_items.name, rental_items.price FROM rented_items
        INNER JOIN rental_items ON rented_items.rental_id = rental_items.id
        WHERE rented_items.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$totalPrice = 0;
$orderItems = array();

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $orderItems[] = array(
      'name' => $row['name'],
      'price' => $row['price']
    );
    $totalPrice += $row['price'];
  }
  $response = array(
    'success' => true,
    'orderItems' => $orderItems,
    'totalPrice' => $totalPrice
  );
} else {
  $response = array(
    'success' => false,
    'message' => 'No items found in the cart.'
  );
}

mysqli_free_result($result);
mysqli_close($conn);

echo json_encode($response);
