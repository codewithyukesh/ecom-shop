<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$pid=get_safe_value($con,$_POST['pid']);
$qty=get_safe_value($con,$_POST['qty']);
$size=get_safe_value($con,$_POST['size']);
$type=get_safe_value($con,$_POST['type']);

$obj=new add_to_cart();

if($type=='add'){
	$obj->addProduct($pid,$qty,$size);
}

if($type=='remove'){
	$obj->removeProduct($pid);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty,$size);
}

echo $obj->totalProduct();
?>