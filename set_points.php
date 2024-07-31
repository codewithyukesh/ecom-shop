<?php
require('connection.inc.php');
require('functions.inc.php');

$cart_total = 0;
$enteredPoints = intval($_POST['points']);
$cartValue = 0;

// Calculate the cart total
foreach ($_SESSION['cart'] as $key => $val) {
    $productArr = get_product($con, '', '', $key);
    $price = $productArr[0]['price'];
    $qty = $val['qty'];
    $cartValue += ($price * $qty);
}

// Step 1: Check cart value
if ($cartValue >= 1000) {
    // Step 2: Check user's points in the database
    $uid = $_SESSION['USER_ID']; // Replace 'user_id' with the actual session variable storing the user ID
    $userPoints = 0;

    // Query the user table to retrieve the user's points
    $query = "SELECT points FROM user WHERE id = '$uid'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $userPoints = $row['points'];
    } else {
        // Handle the case when the query fails
        // You can set a default value for userPoints or return an error response
        $jsonArr = array(
            'is_error' => 'yes',
            'result' => $cartValue,
            'dd' => 'Error: User points not found.'
        );
        echo json_encode($jsonArr);
        exit; // Exit the script execution
    }

    // Debugging output
    // echo "User Points: " . $userPoints . "<br>";

    if ($userPoints >= $enteredPoints && $enteredPoints >= 1000) {
        // Calculate the point value to subtract from the cart value
        $pointValue = $enteredPoints * 0.1;
        $updatedCartValue = $cartValue - $pointValue;

        // Update the cart value in the database or any other storage
        // Replace the following example code with your logic to update the cart value
        // $sql = "UPDATE cart SET value = $updatedCartValue WHERE user_id = '123'";
        // mysqli_query($connection, $sql);

        // Store the applied points details in the database table named 'order'
        // $query = "INSERT INTO `order` (user_id, applied_points) VALUES ('$uid', '$enteredPoints')";
        // mysqli_query($con, $query);

        // Get the order ID
        $orderID = mysqli_insert_id($con);

        // Store the order details (order ID, product ID, quantity, and price) in the database table named 'order_detail'
        foreach ($_SESSION['cart'] as $key => $val) {
            $productArr = get_product($con, '', '', $key);
            $productID = $productArr[0]['id'];
            $quantity = $val['qty'];
            $price = $productArr[0]['price'];

            // $query = "INSERT INTO order_detail (order_id, product_id, quantity, price) VALUES ('$orderID', '$productID', '$quantity', '$price')";
            // mysqli_query($con, $query);
        }

        // Award points to the user if the cart total is above 1000
        // $awardedPoints = 100; // Change this value as per your requirement
        // $updatedPoints = $userPoints + $awardedPoints; // Update the user's points balance
        // $_SESSION['USER_POINTS'] = $updatedPoints; // Update the session variable for user points

        // // Update the user's points balance in the 'user' table
        // $query = "UPDATE user SET points = '$updatedPoints' WHERE id = '$uid'";
        // mysqli_query($con, $query);

        // Insert a record into the 'pointtransaction' table
        // $query = "INSERT INTO pointtransaction (user_id, points) VALUES ('$uid', '$awardedPoints')";
        // mysqli_query($con, $query);

        $jsonArr = array(
            'is_error' => 'no',
            'result' => $updatedCartValue,
            'dd' => 'Points applied successfully. Cart has been updated.',
            'appliedPoints' => $enteredPoints, // Add the appliedPoints field to the JSON response
            'pointValue' => $pointValue // Add the pointValue field to the JSON response
        );
    } else {
        $jsonArr = array(
            'is_error' => 'yes',
            'result' => $cartValue,
            'dd' => 'Invalid point value. Please enter a value greater than or equal to 1000 and within your available points.'
        );
    }
} else {
    $jsonArr = array(
        'is_error' => 'yes',
        'result' => $cartValue,
        'dd' => 'Cart value is less than 1000. Points cannot be applied.'
    );
}

echo json_encode($jsonArr);
exit;
?>
