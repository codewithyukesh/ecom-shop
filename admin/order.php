<?php
require('top.inc.php');

$sql="select * from `order` order by id desc";
$res=mysqli_query($con,$sql);
?>
<div id="notificationPopup" style="display: none;">
  <p>New order has been placed!</p>
</div>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Orders List </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
							<thead>
								<tr>
									<th class="product-thumbnail"><b>Order ID</b></th>
									<th class="product-name"><span class="nobr"><b>Order Date</span></th>
									<th class="product-price"><span class="nobr"><b>Customer Name & Address </b></span></th>
									<th class="product-stock-stauts"><span class="nobr"><b> Payment Type </b> </span></th>
									<th class="product-stock-stauts"><span class="nobr"><b> Payment Status </b></span></th>
									<th class="product-stock-stauts"><span class="nobr"><b> Order Status </b></span></th>
									<th class="product-stock-stauts"><span class="nobr"><b> Change Status </b></span></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$res=mysqli_query($con,"select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status");
								while($row=mysqli_fetch_assoc($res)){
								?>
								<tr>
									<td class="product-add-to-cart"><a href="order_detail.php?id=<?php echo $row['id']?>"> <?php echo $row['id']?></a></td>
									<td class="product-name"><?php echo $row['added_on']?></td>
									<td class="product-name">
									<?php echo $row['address']?>,
									<?php echo $row['city']?><br/>
									<?php echo $row['pincode']?>
									</td>
									<td class="product-name"><?php echo $row['payment_type']?></td>
									<td class="product-name"><?php echo $row['payment_status']?></td>
									<td class="product-name"><?php echo $row['order_status_str']?></td>
									<td class="product-add-to-cart"><a href="order_detail.php?id=<?php echo $row['id']?>"> <?php echo "<span class='badge badge-edit'>UPDATE</span>" ?></a>

									<a href="../order_pdf.php?id=<?php echo $row['id']?>"> <?php echo "<span class='badge badge-dark'>PDF</span>" ?></a>
								</td>
									 
							   </td>
								</tr>
								<?php } ?>
							</tbody>
							
						</table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<script src="orderspop.js"></script>
<?php
require('footer.inc.php');
?>