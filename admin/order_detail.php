<?php
require('top.inc.php');
$order_id=get_safe_value($con,$_GET['id']);
$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value,coupon_code,applied_points from `order` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$coupon_code=$coupon_details['coupon_code'];

// $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select applied_points from `order` where id='$order_id'"));
$enteredPoints=$coupon_details['applied_points'];
$pointValue =$enteredPoints*0.1;
 
// if(isset($_POST['update_order_status'])){
// 	$update_order_status=$_POST['update_order_status'];
// 	if($update_order_status=='5'){
// 		mysqli_query($con,"update `order` set order_status='$update_order_status',payment_status='Success' where id='$order_id'");
// 	}else{
// 		mysqli_query($con,"update `order` set order_status='$update_order_status' where id='$order_id'");
// 	}
	
// }  // old 

if (isset($_POST['update_order_status'])) {
    $update_order_status = $_POST['update_order_status'];
    if ($update_order_status == '5') {
        mysqli_query($con, "update `order` set order_status='$update_order_status',payment_status='Success' where id='$order_id'");
        
        // Add 100 points to the user's points table
        // Assuming the user ID is stored in the session as $_SESSION['user_id']
        $uid = $_SESSION['USER_ID'];
        mysqli_query($con, "UPDATE user SET points = points + 100 WHERE id='$uid'");
		 // Add a record to the pointtransaction table
		 mysqli_query($con, "INSERT INTO `pointtransaction` ( `user_id`, `transaction_type`, `points`, `source`) VALUES('$uid', 'Credit', 100, 'Order')");
		 mysqli_query($con, "UPDATE user SET points = points - $enteredPoints WHERE id='$uid'");
		 // Add a record to the pointtransaction table
		 
   
    } else {
        mysqli_query($con, "update `order` set order_status='$update_order_status' where id='$order_id'");
    }
}
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Detail </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
								<thead>
									<tr>
										<th class="product-thumbnail">Product Name</th>
										<th class="product-thumbnail">Product Image</th>
										<th class="product-name">Qty</th>
										<th class="product-name">Size</th>
										<th class="product-price">Price</th>
										<th class="product-price">Total Price</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image,product.size,`order`.address,`order`.city,`order`.pincode from order_detail,product ,`order` where order_detail.order_id='$order_id' and  order_detail.product_id=product.id GROUP by order_detail.id");
									$total_price=0;
									while($row=mysqli_fetch_assoc($res)){
									
									$userInfo=mysqli_fetch_assoc(mysqli_query($con,"select * from `order` where id='$order_id'"));
									
									$address=$userInfo['address'];
									$city=$userInfo['city'];
									$pincode=$userInfo['pincode'];
									
									$total_price=$total_price+($row['qty']*$row['price']);
									?>
									<tr>
										<td class="product-name"><?php echo $row['name']?></td>
										<td class="product-name"> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"></td>
										<td class="product-name"><?php echo $row['qty']?></td>
										<td class="product-name"><?php echo $row['size']?></td>
										<td class="product-name"><?php echo $row['price']?></td>
										<td class="product-name"><?php echo $row['qty']*$row['price']?></td>
										
									</tr>
									<?php } ?>
									<?php if($coupon_value!=''){ ?>
									<tr>
										<td colspan="4"></td>
										<td class="product-name">Coupon Value</td>
										<td class="product-name">
										<?php 
										echo $coupon_value."($coupon_code)";
										?></td>
										
									</tr>
									<?php } ?>
									<?php if($enteredPoints!=''){ ?>
									<tr>
										<td colspan="4"></td>
										<td class="product-name">Points Value</td>
										<td class="product-name">
										<?php 
										echo "Used Points ".$enteredPoints."( Rs. $pointValue)";
										?></td>
										
									</tr>
									<?php } ?>
									<tr>
									 
										<td colspan="4"></td>
										<td class="product-name">Total Price</td>
										<td class="product-name"><?php echo $total_price-$coupon_value-$pointValue; ?></td>
										
									</tr>
									 
								
								</tbody>
							
						</table>
						<div id="address_details">
							<strong> &nbsp;Address</strong>
							<?php echo $address?>, <?php echo $city?>, <?php echo $pincode?><br/>
							<strong>&nbsp;Payment Method</strong>
							<?php 
							$payment_type_arr=mysqli_fetch_assoc(mysqli_query($con,"select payment_type from `order` where `order`.id='$order_id'"));
							echo $payment_type_arr['payment_type']; 
							?>
							
							<br><strong> &nbsp;Order Status</strong>
							<?php 
							$order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,`order` where `order`.id='$order_id' and `order`.order_status=order_status.id"));
							echo $order_status_arr['name']; 
							?>
							
							<div>
								<form method="post">
								</br><select class="form-control" name="update_order_status" required>
									<option value="">Select Status</option>
										<?php
										$res=mysqli_query($con,"select * from order_status");
										while($row=mysqli_fetch_assoc($res)){
											if($row['id']==$categories_id){
												echo "<option selected value=".$row['id'].">".$row['name']."</option>";
											}else{
												echo "<option value=".$row['id'].">".$row['name']."</option>";
											}
										}
										?>
									</select>
									</br>
									<input type="submit" class="form-control" style="background-color:#2E9F21; color:white;">
								</form>
								<button class="form-control"> <a href="order.php">Back to Orders List</a></button>
							</div>
						</div>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php
require('footer.inc.php');
?>