
<?php
// store_userusedpoint.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userusedpoint'])) {
    // Sanitize and assign the entered points value to the $userusedpoint variable
    $userusedpoint = intval($_POST['userusedpoint']);

    // You can perform additional validation or processing here if needed

    // Store the value in a session or wherever you need to access it later
    session_start();
    $_SESSION['userusedpoint'] = $userusedpoint;

    // Send a response back to the client (JavaScript) if needed
    // For example, you can echo a success message or JSON data
    echo json_encode(['status' => 'success']);
} else {
    // Handle invalid or missing data
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
