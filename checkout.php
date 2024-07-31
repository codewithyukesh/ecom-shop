<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_start();
require('top.php');

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
?>
	<script>
		window.location.href = 'index.php';
	</script>
<?php
}

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

	$newappliedPoints = 1;

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


	// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 	$user_id = $_POST['user_id'];
	// 	$appliedPoints = $_POST['appliedPoints'];
	
	// 	// Access the enteredPoints value from JavaScript
	// 	$enteredPoints = isset($_POST['enteredPoints']) ? $_POST['enteredPoints'] : 0;
	// }
		

	if (isset($_SESSION['POINTS_APPLIED'])) {
		$appliedPoints = $_SESSION['POINTS_APPLIED'];
		$total_price -= ($appliedPoints * 0.1); // Subtracting the points value from the total price
		$newappliedPoints =$appliedPoints;
		
	} else
	 {
		$appliedPoints = 1; // Default value
	}

// Retrieve the entered points value from the session
if (isset($_SESSION['userusedpoint'])) {
    $userusedpoint = $_SESSION['userusedpoint'];
    // Now you can use $userusedpoint as needed in your PHP code
} else {
    // Handle the case where the session variable is not set
}
	// mysqli_query($con, "INSERT INTO `pointtransaction` (user_id, transaction_type, points, source) VALUES ('$user_id', 'Debited', '$userusedpoint', 'On Purchase/Checkout from session')");
	/// points reddeming transaction detailssss

	// if (isset($_POST['user_id']) && isset($_POST['transaction_type']) && isset($_POST['points']) && isset($_POST['source'])) {
	// 	$user_id = $_POST['user_id'];
	// 	$transaction_type = $_POST['transaction_type'];
	// 	$points = $_POST['points'];
	// 	$source = $_POST['source'];
	
	// 	// Insert applied points into the "pointtransaction" table
	// 	$insert_query = "INSERT INTO `pointtransaction` (user_id, transaction_type, points, source) VALUES ('$user_id', '$transaction_type', '$points', '$source')";
	// 	$insert_result = mysqli_query($con, $insert_query);
	
	// 	if ($insert_result) {
	// 		echo json_encode(array('status' => 'success'));
	// 	} else {
	// 		echo json_encode(array('status' => 'error', 'message' => mysqli_error($con)));
	// 	}
	// } else {
	// 	echo json_encode(array('status' => 'error', 'message' => 'Invalid parameters'));
	// }

	//eendd heereee

	

	mysqli_query($con, "INSERT INTO `order` (user_id, address, city, pincode, payment_type, payment_status, order_status, added_on, total_price, coupon_id, coupon_code, coupon_value, applied_points) VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$payment_status', '$order_status', '$added_on', '$total_price', '$coupon_id', '$coupon_code', '$coupon_value', '$userusedpoint')");

	$order_id = mysqli_insert_id($con);

	mysqli_query($con, "INSERT INTO `pointtransaction` (user_id, transaction_type, points, source) VALUES ('$user_id', 'Debited', '$userusedpoint', 'On Purchase / Checkout')");

	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];

		mysqli_query($con, "INSERT INTO `order_detail` (order_id, product_id, qty, price) VALUES ('$order_id', '$key', '$qty', '$price')");
	}

	unset($_SESSION['cart']);
?>
	<script>
		window.location.href = 'thank_you.php';
	</script>
<?php
}
?>
 
<div class="ht__bradcaump__area" style="background: #19c4f6; ;">
	<div class="ht__bradcaump__wrap">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="bradcaump__inner">
						<nav class="bradcaump-inner">
							<a class="breadcrumb-item" href="index.php">Home</a>
							<span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
							<span class="breadcrumb-item active">checkout</span>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="checkout__inner">
					<div class="accordion-list">
						<div class="accordion">

							<?php
							$accordion_class = 'accordion__title';
							if (!isset($_SESSION['USER_LOGIN'])) {
								$accordion_class = 'accordion__hide';
							?>
								<div class="accordion__title">
									Checkout Method
								</div>
								<div class="accordion__body">
									<div class="accordion__body__form">
										<div class="row">
											<div class="col-md-6">
												<div class="checkout-method__login">
													<form id="login-form" method="post">
														<h5 class="checkout-method__title">Login</h5>
														<div class="single-input">
															<input type="text" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
															<span class="field_error" id="login_email_error"></span>
														</div>

														<div class="single-input">
															<input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
															<span class="field_error" id="login_password_error"></span>
														</div>

														<p class="require">* Required fields</p>
														<div class="dark-btn">
															<button type="button" class="fv-btn" onclick="user_login()">Login</button>
														</div>
														<div class="form-output login_msg">
															<p class="form-messege field_error"></p>
														</div>
													</form>
												</div>
											</div>
											<div class="col-md-6">
												<div class="checkout-method__login">
													<form id="register-form" method="post">
														<h5 class="checkout-method__title">Register</h5>
														<div class="single-input">
															<input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
															<span class="field_error" id="name_error"></span>
														</div>
														<div class="single-input">
															<input type="text" name="email" id="email" placeholder="Your Email*" style="width:100%">
															<span class="field_error" id="email_error"></span>
														</div>

														<div class="single-input">
															<input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
															<span class="field_error" id="mobile_error"></span>
														</div>
														<div class="single-input">
															<input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
															<span class="field_error" id="password_error"></span>
														</div>
														<div class="single-input">
															<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password*" style="width:100%">
															<span class="field_error" id="password_error"></span>
														</div>
														<div class="single-input">
															<input type="text" name="referral_code" id="referral_code" value="" placeholder="Referral Code " style="width:100%">
															<span class="field_error" id="password_error"></span>
														</div>
														<div class="dark-btn">
															<button type="button" class="fv-btn" onclick="user_register()">Register</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="<?php echo $accordion_class ?>">
								Address Information
							</div>
							<form method="post">
								<div class="accordion__body">
									<div class="bilinfo">

										<div class="row">
											<div class="col-md-12">
												<div class="single-input">
													<input type="text" name="address" placeholder="Name" value="<?php echo isset($_SESSION['USER_NAME']) ? $_SESSION['USER_NAME'] : '' ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="city" placeholder="Address" required>
												</div>
											</div>
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="pincode" placeholder="Ward number" required>
												</div>
											</div>

										</div>

									</div>
								</div>
								<div class="<?php echo $accordion_class ?>">
									payment information
								</div>
								<div class="accordion__body">
									<div class="paymentinfo">
										<div class="single-method">
											<input type="radio" name="payment_type" value="COD" required /> COD (Cash on Delivery)
											<br>
											<input type="radio" name="payment_type" value="e-sewa" required /> e-sewa (9816465902)
										</div>
										<div class="single-method">

										</div>
									</div>
								</div>
								<input type="submit" class="fv-btn" name="submit" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="order-details">
					<h5 class="order-details__title">Your Order</h5>
					<div class="order-details__item">
						<?php
						$cart_total = 0;
						foreach ($_SESSION['cart'] as $key => $val) {
							$productArr = get_product($con, '', '', $key);
							$pname = $productArr[0]['name'];
							$mrp = $productArr[0]['mrp'];
							$price = $productArr[0]['price'];
							$image = $productArr[0]['image'];
							$qty = $val['qty'];
							$cart_total = $cart_total + ($price * $qty);
						?>
							<div class="single-item">
								<div class="single-item__thumb">
									<img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>" />
								</div>
								<div class="single-item__content">
									<a href="#"><?php echo $pname ?></a>
									<span class="price"><?php echo $price * $qty ?></span>
								</div>
								<div class="single-item__remove">
									<a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="icon-trash icons"></i></a>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="ordre-details__total" id="coupon_box">
						<h5>Coupon Value</h5>
						<span class="price" id="coupon_price"></span>
					</div>
					<div class="ordre-details__total" id="points_box">
						<h5>Points Redeemed</h5>
						<span class="price" id="applied_points"></span>
					</div>
					<div class="ordre-details__total" id="points_box">
						<h5>Points Value <br>(1 point = Rs.0.1)</h5>
						<span class="price" id="pointValue"></span>
					</div>
					 
					<div class="ordre-details__total">
						<h5>Order total</h5>
						<span class="price" id="order_total_price"><?php echo $cart_total ?></span>
					</div>
					<!-- <div id="coupon_result"></div> -->
					<div id="points_result"></div>
					<div class="ordre-details__total bilinfo">
						<input type="textbox" id="coupon_str" class="coupon_style mr5" /> <input type="button" name="submit" class="fv-btn coupon_style" value="Apply Coupon" onclick="set_coupon()" />

					</div>

					<div class="ordre-details__total bilinfo">
						<input type="textbox" id="points_input" class="coupon_style mr5" /> <input type="button" name="submit" class="fv-btn coupon_style" value="Use Points" onclick="set_points()" />


					</div>


				</div>
			</div>
		</div>
	</div>
</div>
<script>
	
	function set_coupon() {
		var coupon_str = jQuery('#coupon_str').val();
		if (coupon_str != '') {
			jQuery('#coupon_result').html('');
			jQuery.ajax({
				url: 'set_coupon.php',
				type: 'post',
				data: 'coupon_str=' + coupon_str,
				success: function(result) {
					var data = jQuery.parseJSON(result);
					if (data.is_error == 'yes') {
						jQuery('#coupon_box').hide();
						jQuery('#coupon_result').html(data.dd);
						jQuery('#order_total_price').html(data.result);
					}
					if (data.is_error == 'no') {
						jQuery('#coupon_box').show();
						jQuery('#coupon_price').html(data.dd);
						jQuery('#order_total_price').html(data.result);
					}
				}
			});
		}
	} 
	// function set_points() {
	// 	var enteredPoints = parseInt($('#points_input').val());

	// 	if (!isNaN(enteredPoints) && enteredPoints >= 1000) {
	// 		$('#points_result').html('');

	// 		$.ajax({
	// 			url: 'set_points.php',
	// 			type: 'post',
	// 			data: {
	// 				points: enteredPoints
	// 			},
	// 			dataType: 'json',
	// 			success: function(data) {
	// 				if (data.is_error === 'yes') {
	// 					$('#points_result').html(data.dd);
	// 					$('#order_total_price').html(data.result);
	// 					// Handle error scenario, display error message, etc.
	// 				} else if (data.is_error === 'no') {
	// 					$('#points_result').html(data.dd);
	// 					$('#order_total_price').html(data.result);
	// 					$('#applied_points').text(data.appliedPoints); // Update the applied points 
	// 					$('#pointValue').text(data.pointValue); // Update the applied points value
	// 					// Update other elements or perform additional actions on success
	// 				}
	// 			},
	// 			error: function(jqXHR, textStatus, errorThrown) {
	// 				console.log(jqXHR.responseText); // Log the detailed error message returned by the server
	// 				alert('Error occurred while applying points.');
	// 				// Handle error scenario, display error message, etc.
	// 			}
	// 		});
	// 	} else {
	// 		alert('Invalid point value. Please enter a value greater than or equal to 1000.');
	// 		// Handle invalid point value scenario, display error message, etc.
	// 	}
	// }
    var userusedpoint = 0.1; // Initialize the userusedpoint variable

	function set_points() {
    var enteredPoints = parseInt($('#points_input').val());

    if (!isNaN(enteredPoints) && enteredPoints >= 1000) {
        $('#points_result').html('');
		userusedpoint = enteredPoints; // Store the entered points value in userusedpoint variable

        $.ajax({
            url: 'set_points.php',
            type: 'post',
            data: {
                points: enteredPoints
            },
            dataType: 'json',
            success: function(data) {
                if (data.is_error === 'yes') {
                    $('#points_result').html(data.dd);
                    $('#order_total_price').html(data.result);
                    // Handle error scenario, display error message, etc.
                } else if (data.is_error === 'no') {
                    $('#points_result').html(data.dd);
                    $('#order_total_price').html(data.result);
                    $('#applied_points').text(data.appliedPoints); // Update the applied points 
                    $('#pointValue').text(data.pointValue); // Update the applied points value
                    
                    // Insert applied points into the "pointtransaction" table
                    $.ajax({
                        url: 'insert_pointtransaction.php', // Create a separate PHP file to handle this insertion
                        type: 'post',
                        data: {
                            user_id: '<?php echo $_SESSION["USER_ID"]; ?>',
                            transaction_type: 'Debited',
                            points: enteredPoints,
                            source: 'On Purchase/Checkout from function'
                        },
                        success: function(response) {
                            // Handle success or error messages
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle error scenario
                        }
                    });
					$.ajax({
            url: 'store_userusedpoint.php', // Create a separate PHP file for this purpose
            type: 'post',
            data: {
                userusedpoint: enteredPoints // Send the entered points value to the server
            },
            success: function(response) {
                // Handle success or error messages if needed
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle error scenario
            }
        });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText); // Log the detailed error message returned by the server
                alert('Error occurred while applying points.');
                // Handle error scenario, display error message, etc.
            }
        });
    } else {
        alert('Invalid point value. Please enter a value greater than or equal to 1000.');
        // Handle invalid point value scenario, display error message, etc.
    }
}

</script>
<?php
if (isset($_SESSION['COUPON_ID'])) {
	unset($_SESSION['COUPON_ID']);
	unset($_SESSION['COUPON_CODE']);
	unset($_SESSION['COUPON_VALUE']);
}
require('footer.php');
?>
