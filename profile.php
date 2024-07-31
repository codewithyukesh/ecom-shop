<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>
<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: #19c4f6;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Profile</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
      
      <br>
        <style>
.alert {
  padding: 20px;
  background-color: #04AA6D;
  color: white;
  width: 390px;
  float:right;
  position: relative;

  
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
</head>
<body>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
   You can earn 20 points on per refer & 100 points on per purchase.
</div>
      <!-- Start Contact Area -->
    <section class="htc__contact__area ptb--100 bg__white">
      
            <div class="container">
             <div class="row">
              
					<div class="col-md-6">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Your referral code & Eared points</h2>
								</div>
							</div>
              <?php 
										
											if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']==true)
											{

										
											$query="SELECT * FROM `user` WHERE `id`='$_SESSION[USER_ID]'";
											$result=mysqli_query($con,$query);
											$result_fetch=mysqli_fetch_assoc($result);
										    }
										   ?>
							<div class="col-xs-12">
                <form method="post" id="frmPassword">
                  <div class="single-contact-form">
                    <label class="password_label">Referral Code :</label>
                    <div class="contact-box name">
                      <input type="text" readonly style="width:100%" value="<?php echo " $result_fetch[referral_code]"?>">
                    </div>
                    
                  </div>
                  <div class="single-contact-form">
                    <label class="password_label">Earned points : <a href="./pointsdetails.php">See Points Detail</a> </label>
                    <div class="contact-box name">
                      <input type="text"   readonly style="width:100%" value="<?php echo "$result_fetch[points]";?> " >
                      </div>
                      </div>
                        <div class="single-contact-form">
                      <label class="password_label">Referral link :</label>
                      <div class="contact-box name">
                      <input type="text" readonly style="width:100%" onclick="copyReferralLink()" value="<?php echo 'http://127.0.0.1/shop/login.php?referral=' . $result_fetch['referral_code']; ?>">

                      <!-- <input type="text" readonly style="width:100%" value="<?php echo 'http://127.0.0.1/shop/login.php?referral=' . $result_fetch['referral_code']; ?>"> -->
                        </div>
                        </div>


					<!-- <div class="single-contact-form">
                    <label>Rewards :</label>
                      <li>200 Point = It can be used towards a 100 RS recharge.</li>

                       <li> 400 Point = It can be used to get a T-shirt.</li> 

                         <li> 800 Point = It  can be used to get a leather jacket. </li> 

						 <li>  1000 Point = It can be used to get a set of pant-shirt along with a pair of shoes.</li>
                      </div> -->
                    </div>
               </form>
             </div>
        </div>
              
        <div class="row">
          <div class="col-md-6">
            <div class="contact-form-wrap mt--60">
              <div class="col-xs-12">
				 <div class="contact-title">
                  <h2 class="title__line--6">Profile</h2>
                </div>
              </div>
              <div class="col-xs-12">
                <form id="login-form" method="post">
                 <div class="single-contact-form">
                    <label class="password_label">User Name :</label>
                    <div class="contact-box name">
                      <input type="text" name="name" id="name" placeholder="Your Name*" readonly style="width:100%" value="<?php echo $_SESSION['USER_NAME']?>">
                      </div>
                    </div>
					<?php
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']==true)
{


$query="SELECT * FROM `user` WHERE `id`='$_SESSION[USER_ID]'";
$result=mysqli_query($con,$query);
$result_fetch=mysqli_fetch_assoc($result);
}
?>



					  <div class="single-contact-form">
                    <label class="password_label">Email :</label>
                    <div class="contact-box name">
                      <input type="text" name="name" id="name" placeholder="Your Name*" readonly style="width:100%" value="<?php echo "$result_fetch[email]"?>">
                      </div>
                    </div>
					 <div class="single-contact-form">
                    <label class="password_label">Contact Number :</label>
                    <div class="contact-box name">
                      <input type="text" name="name" id="name" placeholder="Your Name*" readonly style="width:100%" value="<?php echo "$result_fetch[mobile]"?>">
                      </div>
                    </div>

                  
                  
                </form>
                
                
                
              </div>
            </div> 
                
        </div>
    </div>

</section>
<script>
function copyReferralLink() {
  var referralLinkInput = document.getElementById("referralLink");
  referralLinkInput.select();
  referralLinkInput.setSelectionRange(0, 99999); // For mobile devices
  document.execCommand("copy");
  alert("Referral link copied to clipboard!");
}
</script>
<?php require('footer.php')?>  
      