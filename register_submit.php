<?php
require('connection.inc.php');
require('functions.inc.php');

$name = get_safe_value($con, $_POST['name']);
$email = get_safe_value($con, $_POST['email']);
$mobile = get_safe_value($con, $_POST['mobile']);
$password = get_safe_value($con, $_POST['password']);
$refcode = get_safe_value($con, $_POST['referral_code']);

$added_on = date('Y-m-d h:i:s');
$check_user = mysqli_num_rows(mysqli_query($con, "select * from user where email='$email'"));
$referral_code_valid = true;

if ($refcode != '') {
	$check_referralcode = mysqli_num_rows(mysqli_query($con, "select * from user where referral_code='$refcode'"));
	if ($check_referralcode == 0) {
		$referral_code_valid = false;
	}
}

if ($check_user > 0) {
	echo "email_present";
} else {
	if (!$referral_code_valid) {
		echo "invalid_referral_code";
	} else {
		if($refcode == ''){
			$referral_code = strtoupper(bin2hex(random_bytes(3)));
		$insert_query = "insert into user(name,email,mobile,password,added_on,referral_code,points) values('$name','$email','$mobile','$password','$added_on','$referral_code',0)";
		}else {
			$referral_code = strtoupper(bin2hex(random_bytes(3)));
		$insert_query = "insert into user(name,email,mobile,password,added_on,referral_code,points) values('$name','$email','$mobile','$password','$added_on','$referral_code',10)";
		if ($refcode != '') {
			// User has a valid referral code, increase points
			increase_user_points($con, $refcode, 20);
		}
		}
		
		mysqli_query($con, $insert_query);
		$res = mysqli_query($con, "select * from user where email='$email' and password='$password'");
		$check_user = mysqli_num_rows($res);
		if ($check_user > 0) {
			$row = mysqli_fetch_assoc($res);
			$_SESSION['USER_LOGIN'] = 'yes';
			$_SESSION['USER_ID'] = $row['id'];
			$_SESSION['USER_NAME'] = $row['name'];

			if (isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID'] != '') {
				wishlist_add($con, $_SESSION['USER_ID'], $_SESSION['WISHLIST_ID']);
				unset($_SESSION['WISHLIST_ID']);
			}
			
			echo "insert";
		}
	}
}

function increase_user_points($con, $refcode, $points) {
	$user_query = "select * from user where referral_code='$refcode'";
	$user_res = mysqli_query($con, $user_query);
	
	if (mysqli_num_rows($user_res) > 0) {
		$user_row = mysqli_fetch_assoc($user_res);
		$user_id = $user_row['id'];
		$user_points = $user_row['points'];
		$new_points = $user_points + $points;
		
		$update_query = "update user set points=$new_points where id=$user_id";
		mysqli_query($con, $update_query);
	}
}
?>