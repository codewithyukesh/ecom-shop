 //old checkout page codes 

 <?php
require('top.php');
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
?>
	<script>
		window.location.href = 'index.php';
	</script>
<?php
}
// $appliedPoints = isset($_SESSION['APPLIED_POINTS']) ? $_SESSION['APPLIED_POINTS'] : 0;

$cart_total = 0;

if (isset($_POST['submit'])) {
	$address = get_safe_value($con, $_POST['address']);
	$city = get_safe_value($con, $_POST['city']);
	$pincode = get_safe_value($con, $_POST['pincode']);
	$payment_type = get_safe_value($con, $_POST['payment_type']);
	$user_id = $_SESSION['USER_ID'];
	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];
		$cart_total = $cart_total + ($price * $qty);
	}
	$total_price = $cart_total;
	$payment_status = 'pending';
	if ($payment_type == 'cod') {
		$payment_status = 'success';
	}
	$order_status = '1';
	$added_on = date('Y-m-d h:i:s');

	if (isset($_SESSION['COUPON_ID'])) {
		$coupon_id = $_SESSION['COUPON_ID'];
		$coupon_code = $_SESSION['COUPON_CODE'];
		$coupon_value = $_SESSION['COUPON_VALUE'];
		$total_price = $total_price - $coupon_value;
		unset($_SESSION['COUPON_ID']);
		unset($_SESSION['COUPON_CODE']);
		unset($_SESSION['COUPON_VALUE']);
	} else {
		$coupon_id = '';
		$coupon_code = '';
		$coupon_value = '';
	}
	if (isset($_SESSION['POINTS_APPLIED']) && $_SESSION['POINTS_APPLIED']) {
		$appliedPoints = $_SESSION['APPLIED_POINTS'];
		$total_price = $_SESSION['UPDATED_CART_TOTAL'];
		// $pointValue = $appliedPoints*0.1;
	}

	mysqli_query($con, "insert into `order`(user_id,address,city,pincode,payment_type,payment_status,order_status,added_on,total_price,coupon_id,coupon_code,coupon_value) values('$user_id','$address','$city','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price','$coupon_id','$coupon_code','$coupon_value')");

	$order_id = mysqli_insert_id($con);

	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];

		mysqli_query($con, "insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
	}

	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];
		$cart_total = $cart_total + ($price * $qty);
	}

	// if ($cart_total > 1000) {
	// 	$points_to_award = 100; // Adjust this value as per your requirements
	// 	// Update the user's points balance in the User table
	// 	mysqli_query($con, "UPDATE `user` SET points = points + $points_to_award WHERE id = '$uid'");
	// 	// Insert a record in the Point Transaction table
	// 	mysqli_query($con, "INSERT INTO `pointtransaction` (user_id, points,transaction_type, source) VALUES ('$uid', $points_to_award, 'Earning/Credited', 'Cart Value')");
	// }


	unset($_SESSION['cart'])
?>
	<script>
		window.location.href = 'thank_you.php';
	</script>
<?php


}
?>
