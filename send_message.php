<?php
require('connection.inc.php');
require('functions.inc.php');
$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$mobile=get_safe_value($con,$_POST['mobile']);
$comment=get_safe_value($con,$_POST['message']);
$addedon=date('Y-m-d h:i:s');
mysqli_query($con,"insert into contact_us(name,email,mobile,comment,addedon) values('$name','$email','$mobile','$comment','$addedon')");
echo "Thank you. You're Message/Mail has been sent.";
?>