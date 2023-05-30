<!DOCTYPE html>
<html>
  <head>
    
    <title>Add Products</title>
    <style>
      /* Global Styles */

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  color: #333;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  font-size: 36px;
  margin-bottom: 20px;
}

form label {
  display: block;
  margin-bottom: 10px;
  font-size: 18px;
}

form input,
form textarea {
  display: block;
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form textarea {
  height: 200px;
}

form input[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  font-size: 18px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

form input[type="submit"]:hover {
  background-color: #3e8e41;
}

/* Media Queries */

@media screen and (max-width: 600px) {
  .container {
    padding: 10px;
  }
  
  h1 {
    font-size: 24px;
    margin-bottom: 10px;
  }
  
  form label {
    font-size: 16px;
    margin-bottom: 5px;
  }
  
  form input,
  form textarea {
    padding: 5px;
    margin-bottom: 10px;
    font-size: 14px;
  }
  
  form input[type="submit"] {
    font-size: 16px;
    padding: 10px 15px;
  }
  
}
form select {
  display: block;
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form option {
  font-size: 16px;
}
    </style>  

    </head>
        <body>

        <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "rentit");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form values
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Handle the image file upload
    $image = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];
    $image_path = "uploads/" . $image;

    // Move the uploaded file to the specified directory
    move_uploaded_file($image_tmp, $image_path);

    // Prepare the SQL statement
    $sql = "INSERT INTO rental_items (name, description, image, price, quantity) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ssssd", $name, $description, $image_path, $price, $quantity);

    // Set the quantity
    $quantity = 10;

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    // Check if a row was affected
    if ($result) {
        echo "Product added successfully.";
    } else {
        echo "Error adding product: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>

<div class="container">
  <h1>Add Products</h1>
  <form id="add-product-form" method="POST" enctype="multipart/form-data">

    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
      <option value="option1">Tour</option>
      <option value="option2">Vehicles</option>
      <option value="option3">Party</option>
      <option value="option4">Others</option>
    </select>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" required>

    <input type="submit" value="Add Product">
  </form>
</div>
</body>
</html>