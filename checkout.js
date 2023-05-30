document.addEventListener('DOMContentLoaded', () => {
    const orderItems = document.getElementById('order-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutForm = document.getElementById('checkout-form');
    const checkoutMessage = document.getElementById('checkout-message');
  
    // Retrieve the order items from the database
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_order_items.php', true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          const orderItemsHTML = response.orderItems.map(item => `
            <tr>
              <td>${item.name}</td>
              <td>Tk ${item.price}</td>
            </tr>
          `).join('');
  
          orderItems.innerHTML = orderItemsHTML;
          totalPriceElement.textContent = 'Tk ' + response.totalPrice.toFixed(2);
        } else {
          checkoutMessage.textContent = response.message;
        }
      } else {
        console.error(xhr.responseText);
      }
    };
    xhr.send();
  
    // Handle the form submission
    checkoutForm.addEventListener('submit', (event) => {
      event.preventDefault();
      const formData = new FormData(checkoutForm);
  
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'place_order.php', true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            // Order placed successfully, redirect to success page
            window.location.href = 'order_success.html';
          } else {
            checkoutMessage.textContent = response.message;
          }
        } else {
          console.error(xhr.responseText);
        }
      };
      xhr.send(formData);
    });
  });
  