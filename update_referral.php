<?php
function updateReferralp($referral_code) {
    $query = "SELECT * FROM `user` WHERE `referral_code`='$_POST[referral_code]'";
    	$result = mysqli_query($GLOBALS['con'],$query);
    	if(result)
    	{
    		if(mysqli_num_rows($result)==1)
    		{
    			$result_fetch=mysqli_fetch_assoc($result);
    			$points = $result_fetch['points'] + 20;
    			$update_query = "UPDATE `user` SET `points`='$points' WHERE `email`='$result_fetch[email]'";
            
    			if(!mysqli_query($GLOBALS['con'],$update_query))
    			{
    				echo " alert('Cannot Run Query') ";
    				exit;
    
                }         
			}
		    else 
			 {
				echo"<script> 
				alert('Invalid referral code');
				</script> 
				";
				//swal("Invalid referral code", "eStore-Nepal", "error");
				exit;
			  }
			
    	}
		
}
?>