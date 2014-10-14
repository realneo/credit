<?php include_once('templates/header.php'); ?>
        
    <div class='container'>
        <div class='col-24 no-print'>
           <div class='container'>
                <div class='col-header'><p class='text-desaturated-blue padding-10'> <i class="fa fa-file-text fa-1x padding-left-10 text-desaturated-blue"></i> Orders </p></div>
                <nav>
                    <ul>
                        <li id='new_order_form_btn'><a href='#'>New Order</a></li>
                        <li id='pending_orders_btn'><a href='#'>Pending Orders</a></li>
                        <li id='completed_orders_btn'><a href='#'>Completed Orders</a></li>
                    </ul>
               </nav>
            </div><!-- container -->
        </div><!-- col-25 -->
        <div class='col-72' id='content'>
            <div class='alert yellow-bg'><p></p></div>
            <div class='loading'><i class="fa fa-4x fa-refresh fa-spin"></i></div>
            <div class='overlay'></div>
            <div class='container'>
                <div id='inner-content'>
                    
                <!-- Loading Pages Here -->
                </div>
            </div>
        </div><!-- col-72 -->
    </div><!-- .container -->
            
<?php include_once('templates/footer.php'); ?> 
