<!DOCTYPE html>
<html>
<head>
  <title>Cart</title>
  <style>
   body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: lightslategrey;
   }

   h1 {
      font-size: 3em;
      margin-top: 0;
      text-align: center;
   }

   #cart-items {
      list-style-type: none;
      margin: 0;
      padding: 0;
   }

   #cart-items li {
      margin: 0 10px;
      padding: 10px;
   }

   #cart-items li img {
      max-width: 100%;
      height: auto;
   }

   #cart-items li span {
      display: block;
      font-size: 1.2em;
   }

   #cart-items li input {
      width: 20px;
      text-align: justify;
   }

   #cart-items li button {
      margin-right: 30px;
   }
 
   #cart-total {
      margin-top: 20px;
      text-align: center;
      border: 20px solid #ccc;
   }

   #cart-actions {
  text-align: right;
}

#cart-actions button {
  margin-right: 40px;
  padding: 10px 20px;
  font-size: 1.2em;
  background-color: lightslategrey;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#cart-actions button:hover {
  background-color: gray;
}

#cart-actions button:focus {
  outline: none;
}


   #clear-cart-message {
      margin-top: 20px;
      color: rgb(113, 26, 26);
   }
  </style>
</head>
<body>
  <h1>Cart</h1>
  
  <ul id="cart-items">
    <?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect to the login page
        header("Location: login.html?redirect=true");
        exit();
    }

    // Retrieve user ID from session
    $user_id = $_SESSION["user_id"];

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "rentit");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the rented items from the database for the current user
    $sql = "SELECT rental_items.id, rental_items.name, rental_items.price, rental_items.image FROM rented_items
            INNER JOIN rental_items ON rented_items.rental_id = rental_items.id
            WHERE rented_items.user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $totalPrice = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li data-rental-id="' . $row['id'] . '">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
            echo '<span>' . $row['name'] . '</span>';
            echo '<span>Tk ' . $row['price'] . '</span><br>';
            echo '<button class="remove-from-cart">Remove from Cart</button>';
            echo '</li>';
            $totalPrice += $row['price'];
        }
    } else {
        echo '<li>Your cart is empty.</li>';
    }

    // Close the result set and database connection
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
  </ul>

  <div id="cart-total">
    <h2>Total Price: <span id="total-price"><?php echo $totalPrice; ?> Tk</span></h2>
  </div>

  <div id="cart-actions">
    <button id="clear-cart">Clear Cart</button>
    <button id="checkout">Checkout</button>
  </div>

  <div id="clear-cart-message"></div>




  <script>
  const removeFromCartButtons = document.getElementsByClassName('remove-from-cart');
  const clearCartButton = document.getElementById('clear-cart');
  const checkoutButton = document.getElementById('checkout');
  const clearCartMessage = document.getElementById('clear-cart-message');
  const totalPriceElement = document.getElementById('total-price');

  // Attach event listeners to the remove buttons
  Array.from(removeFromCartButtons).forEach((button) => {
    button.addEventListener('click', (event) => {
      const listItem = event.target.parentNode;
      const removeItemId = listItem.getAttribute('data-rental-id');

      // Send an AJAX request to remove the item from the database
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'remove_item.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Item removed successfully
          listItem.remove();
          updateTotalPrice();
        } else {
          // Error occurred while removing item
          console.error(xhr.responseText);
        }
      };
      xhr.send('remove_item_id=' + encodeURIComponent(removeItemId));
    });
  });

  // Attach event listener to the clear cart button
  clearCartButton.addEventListener('click', () => {
    // Send an AJAX request to remove all items from the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'remove_all_items.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Cart cleared successfully
        const cartItems = document.getElementById('cart-items');
        cartItems.innerHTML = '<li>Your cart is empty.</li>';
        updateTotalPrice();
        clearCartMessage.textContent = 'Cart cleared successfully.';
      } else {
        // Error occurred while clearing cart
        console.error(xhr.responseText);
      }
    };
    xhr.send();
  });

  // Attach event listener to the checkout button
checkoutButton.addEventListener('click', () => {
  // Redirect to the checkout page
  window.location.href = 'checkout.php';
});


  // Function to update the total price
  function updateTotalPrice() {
    const cartItems = document.getElementById('cart-items');
    const items = cartItems.getElementsByTagName('li');
    let totalPrice = 0;

    for (let i = 0; i < items.length; i++) {
      const priceElement = items[i].getElementsByTagName('span')[1];
      const price = parseFloat(priceElement.textContent.slice(3)); // Remove "Tk " from the price string
      totalPrice += price;
    }

    totalPriceElement.textContent = 'Tk ' + totalPrice.toFixed(2);
  }
</script>


 
</body>
</html>
