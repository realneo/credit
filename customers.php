<?php include_once('templates/header.php'); ?>
        
    <div class='container'>
        <div class='col-24'>
           <div class='container'>
                <div class='col-header'><p class='text-desaturated-blue padding-10'> <i class="fa fa-users fa-1x padding-left-10 text-desaturated-blue"></i> Customers </p></div>
                <nav>
                    <ul>
                        <li><a href='#'>Add Customer</a></li>
                        <li><a href='#'>View Customers</a></li>
                    </ul>
               </nav>
            </div><!-- container -->
        </div><!-- col-25 -->
        <div class='col-72' id='content'>
            <div class='container'>
                <div class='loading'>
                    <i class="fa fa-4x fa-refresh fa-spin"></i>
                </div>
            </div>
        </div><!-- col-72 -->
    </div><!-- .container -->
            
<?php include_once('templates/footer.php'); ?> 
