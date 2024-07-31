<?php
require('top.php');
?>
<div class="ht__bradcaump__area" style="background: #19c4f6;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Thank You</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tcontainer">
    <h1> Your order has been placed successfully</h1>


    <div class="buttons-cart checkout--btn">
        <a href="<?php echo SITE_PATH ?>index.php">Continue Shopping..</a>
    </div>
    </br>
    <div class="buttons-cart checkout--btn">
        <a href="./my_order.php">Checkout Orders..</a>
    </div>
</div>

<?php require('footer.php') ?>