// admin.js

// Step 1: Set up a timer
setInterval(checkForNewOrders, 60); // Run every 10 minutes

// Step 2: Make an AJAX request
function checkForNewOrders() {
  // Step 2a: Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Step 2b: Set up the AJAX request
  xhr.open('GET', 'check_orders.php', true);

  // Step 2c: Define the AJAX response callback function
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Step 5: Handle the response
      var response = JSON.parse(xhr.responseText);
      if (response.newOrders) {
        showNotificationPopup(response.orderCount);
      }
    }
  };

  // Step 2d: Send the AJAX request
  xhr.send();
}

// Step 5: Show the notification popup
function showNotificationPopup(orderCount) {
  var notificationPopup = document.getElementById('notificationPopup');
  notificationPopup.style.display = 'block';
  notificationPopup.innerHTML = 'New order(s) placed: ' + orderCount;

  // Optional: You can add a close button or other logic to handle dismissing the notification
}
