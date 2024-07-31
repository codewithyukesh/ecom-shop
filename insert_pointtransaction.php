<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('top.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $transaction_type = $_POST['transaction_type'];
    $points = $_POST['points'];
    $source = $_POST['source'];

    // You might want to add additional validation and sanitation here

    // Insert the points into the pointtransaction table
    // $insertQuery = "INSERT INTO `pointtransaction` (user_id, transaction_type, points, source) VALUES ('$user_id', '$transaction_type', '$points', '$source')";
    // $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        $response = array(
            'success' => true,
            'message' => 'Points inserted successfully.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error inserting points: ' . mysqli_error($con)
        );
    }

    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
    echo json_encode($response);
}
?>
