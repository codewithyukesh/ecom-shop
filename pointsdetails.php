<?php
// Your main file

require('top.php');

$user_id = $_SESSION['USER_ID']; // Assuming you have the user ID in the session

// Retrieve point transaction records from the database
$sql = "SELECT transaction_id, transaction_type, points, source, timestamp FROM pointtransaction WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);

// Retrieve remaining points from the user table
$user_query = "SELECT points FROM `user` WHERE id = '$user_id'";
$user_result = mysqli_query($con, $user_query);
$user_row = mysqli_fetch_assoc($user_result);
$remaining_points = $user_row['points'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Transaction Details</title>
    <style>
        /* Styles specific to the point transaction details */
        .transaction-details {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .transaction-details-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .transaction-details h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }
        .transaction-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .transaction-details th, .transaction-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .transaction-details th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .transaction-details tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="transaction-details">
    <div class="transaction-details-container">
        <?php
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Point Transaction Details</h2>";
                echo "<table>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Timestamp</th>
                        <th>Source</th>
                        <th>Transaction Type</th>
                        <th>Points</th>
                    </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['transaction_id'] . "</td>
                        <td>" . date('Y-m-d H:i:s', strtotime($row['timestamp'])) . "</td>
                        <td>" . $row['source'] . "</td>
                        <td>" . $row['transaction_type'] . "</td>
                        <td>" . $row['points'] . "</td>
                    </tr>";
                }

                // Display the row for total remaining points
                echo "<tr>
                        <td colspan='5'><strong>Total Remaining Points: $remaining_points</strong></td>
                    </tr>";

                echo "</table>";
            } else {
                echo "<h2>No point transaction records found.</h2>";
            }
        } else {
            echo "<h2>Query error: " . mysqli_error($con) . "</h2>";
        }
        ?>
        <p><strong>Note:</strong> <br>
1. 100 points will be added when the order status is completed, only if the cart value is greater than 1000. <br>
2. Points used for purchasing will be deducted when the order status is completed.</p>
    </div>
</div>
</body>
</html>
<?php 
// Close the database connection (Note: This may not be necessary if the top.php is included in your main file)
mysqli_close($con);

// Include footer or other content
require('footer.php');
?> 