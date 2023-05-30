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

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "rentit");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL statement
$sql = "INSERT INTO rental_items (name, description, image, price, quantity) VALUES (?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Set the parameters
$name = "My Product";
$description = "This is my product description.";
$image = "product.jpg";
$price = 100;
$quantity = 10;

// Bind the parameters
mysqli_stmt_bind_param($stmt, "sssss", $name, $description, $image, $price, $quantity);

// Execute the statement
mysqli_stmt_execute($stmt);

// Check if a row was affected
if (mysqli_affected_rows($conn) > 0) {
    echo "Product added successfully.";
} else {
    echo "Error adding product.";
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($conn);

?>
  
  


        <div class="container">
         <h1>Add Products</h1>
        <form id="add-product-form">

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name">

        <label for="category">Category:</label>
        <select id="category" name="category">
        <option value="option1">Tour </option>
        <option value="option2">Vehicles </option>
        <option value="option3">Party </option>
        <option value="option4">Others </option>
        </select>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price">
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        
        <input type="submit" value="Add Product">
      </form>   
      
    </div>

    <script>
      const form = document.querySelector('#add-product-form');
      const category = document.querySelector('#product-category').value;

      const imagePreview = document.querySelector('#preview-image');
      const captionPreview = document.querySelector('#preview-caption');
      
      // Show image preview when user selects an image
      document.querySelector('#product-image').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.addEventListener('load', function() {
            imagePreview.setAttribute('src', reader.result);
          });
          reader.readAsDataURL(file);
        }
      });
      
      // Update caption preview as user types in description
      document.querySelector('#product-description').addEventListener('input', function() {
        captionPreview.textContent = this.value;
      });
      
      form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the form from submitting

        // Get the values from the form
        const name = document.querySelector('#product-name').value;
        const price = document.querySelector('#product-price').value;
        const description = document.querySelector('#product-description').value;

        // Do something with the values (e.g. send a request to the backend)
        console.log(`Adding product: ${name}, Price: ${price}, Description: ${description}`);

        // Reset the form
        form.reset();
        imagePreview.setAttribute('src', '#');
        captionPreview.textContent = '';
      });
    </script>
    
  </body>
</html>