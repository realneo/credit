$(function() {
    // Functions
    
    // Alert Function
    function alert_msg(alert_type, alert_msg){
        $('.alert p').html(alert_msg);
        if(alert_type == 'warning'){
            $('.alert').addClass('warning-bg');    
        }else if(alert_type == 'success'){
            $('.alert').addClass('success-bg');    
        }else if(alert_type == 'danger'){
            $('.alert').addClass('danger-bg');                             
        }
        
        $('.alert').fadeIn().delay(10000).fadeOut();
    }
    
    
    
    // Loading a page in the 
    function load_page(selector, file){
        $('.loading').fadeIn();
        $(selector).fadeOut(10).stop().delay(30).load(file, function() {
            $('.loading').fadeOut();
        }).delay(500).fadeIn();
        //$(selector).fadeOut(10).delay(30).load(file).delay(500).fadeIn();
    }
    
    // Add Customer Button
    $('#add_customer_btn').click(function(){
        $(this).addClass('nav-hover');
        $('#view_customers_btn').removeClass('nav-hover');
        load_page('#inner-content', 'includes/new_customer_form.php');
    });
    
    // Add Customer Button
    $('#view_customers_btn').click(function(){
        $('#add_customer_btn').removeClass('nav-hover');
        $(this).addClass('nav-hover');
        load_page('#inner-content', 'includes/view_customers.php');
    });

    // Add Customer Submit Form
    $(document).on("submit", "#add_customer_form", function(e) {
        $('.loading').fadeIn();
        $("input, button").prop('disabled', true);
        // Validate the Form
        if($("input[name='first_name']").val() == 0){
            $("input[name='first_name']").addClass('error-border');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='middle_name']").val() == 0){
            $("input[name='middle_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='last_name']").val() == 0){
            $("input[name='last_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='company_name']").val() == 0){
            $("input[name='company_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='street_name']").val() == 0){
            $("input[name='street_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='city_name']").val() == 0){
            $("input[name='city_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='country_name']").val() == 0){
            $("input[name='country_name']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='email1']").val() == 0){
            $("input[name='email1']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($("input[name='mobile1']").val() == 0){
            $("input[name='mobile1']").addClass('error-border'); 
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else{
            
            var post_data = {
                first_name:$("input[name='first_name']").val(),
                middle_name:$("input[name='middle_name']").val(),
                last_name:$("input[name='last_name']").val(),
                company_name:$("input[name='company_name']").val(),
                street_name:$("input[name='street_name']").val(),
                city_name:$("input[name='city_name']").val(),
                country_name:$("input[name='country_name']").val(),
                email1:$("input[name='email1']").val(),
                email2:$("input[name='email2']").val(),
                mobile1:$("input[name='mobile1']").val(),
                mobile2:$("input[name='mobile2']").val(),
                mobile3:$("input[name='mobile3']").val(),
                mobile4:$("input[name='mobile4']").val()
            };
            var formURL = $(this).attr("action");
            $.ajax({
                url : formURL,
                type: "POST",
                data : post_data,
                success:function(data, textStatus, jqXHR, response){
                    if(jqXHR.responseText == 'customer_exists'){ 
                        var customer_name = post_data.first_name + ' ' + post_data.middle_name + ' ' + post_data.last_name;
                        alert_msg('warning', '<strong>'+customer_name + '</strong> is already in the system.');
                        $("input, button").prop('disabled', false);
                        $('.loading').fadeOut();
                    }
                    else{
                        var customer_name = post_data.first_name + ' ' + post_data.middle_name + ' ' + post_data.last_name;
                        alert_msg('success', '<strong>'+customer_name + '</strong> has been added successfully in the System.');
                        $('input').val('');
                        $("input, button").prop('disabled', false);
                        $('.loading').fadeOut();
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {  
                    $("input, button").prop('disabled', false);
                    $('.loading').fadeOut();
                }
            });
        }
        
        e.preventDefault(); //STOP default action
        //e.unbind(); //unbind. to stop multiple form submit.
    });
    
    // Default Input 
    
    $(document).on("change", "input", function() {
        $(this).removeClass('error-border');
    });
    
    // New Order Button
    $('#new_order_form_btn').click(function(){
        $('#new_order_form_btn').removeClass('nav-hover');
        $(this).addClass('nav-hover');
        load_page('#inner-content', 'includes/new_order_form.php');
    });
    
    // Adding Products to the Order Form
    var products = []; // New Array to hold the products Values
    var total_amount = 0;
    $(document).on("click", "#add_product_btn", function(e) {
        $('.loading').fadeIn();
        var product_name = $("#product_name").val();
        var product_code = $('#product_code').val();
        var product_price = $('#product_price').val();
        var product_quantity = $('#product_quantity').val();
        var product_amount = $('#product_amount').val();
        var number = products.length + 1;
        
        if(!product_name || !product_code || !product_price || !product_quantity){
            alert_msg('warning', 'Please Fill in all the fields before Adding another product');  
            if(!product_name){
                $('#product_name').addClass('error-border');  
            }else if(!product_code){
                $('#product_code').addClass('error-border');
            }else if(!product_price){
                $('#product_price').addClass('error-border');
            }else if(!product_quantity){
                $('#product_quantity').addClass('error-border');
            }
            $('.loading').fadeOut();
        }else{
        
            products[products.length] = [products.length, product_name, product_code, product_price, product_quantity, product_amount]; 

            $('#order_products_display').fadeIn();
            $('#order_products_display tr:last').after('<tr><td>'+number+'</td><td>'+product_name+'</td><td>'+product_code+'</td><td>'+product_price+'</td><td>'+product_quantity+'</td><td>'+product_amount+'</td><td><a href="#" class="remove_btn text-desaturated-blue">Remove</a></td></tr>');

            total_amount = parseInt(total_amount) + parseInt(product_amount);
            $('#total_amount').fadeOut().delay(400).html(total_amount).fadeIn();
            
            //console.log(total_amount);
            //console.log(products);
            //var test = JSON.stringify(products);
            //console.log(test);
            /*
            for(var product = 0; product < products.length; product++){
                console.log(products[product]);
            */
            
            //var test = array2json(products);
            //console.log(test);
            $('.loading').fadeOut();
            
        }
        
        e.preventDefault();
    });
    
    // Amount Calculation System
    $(document).on("change", "#product_quantity", function() {
        $('.loading').fadeIn();
        var product_price = $('#product_price').val();
        var product_quantity = $('#product_quantity').val();
        var product_amount = product_price * product_quantity;
        
        $('#product_amount').val(product_amount);
        $('.loading').fadeOut();
    });
    
    // Remove Products 
    $(document).on("click", ".remove_btn", function() {
        $('.loading').fadeIn();
        $(this).parent().parent().fadeOut();
        var array_id = $(this).parent().siblings().html()-1;
        //products.splice(products[array_id], 1);
        delete products[array_id];
        //console.log(products);
        //total_amount = products[array_id][5];
        var amount = $(this).parent().siblings(':last').html();
        total_amount = parseInt(total_amount) - parseInt(amount);
        $('#total_amount').fadeOut().delay(500).html(total_amount).fadeIn();
        //console.log(total_amount);
        $('.loading').fadeOut();
    });
    
    // Submitting the Order Form 
    $(document).on("submit", "#new_order_form", function(e) {
        $('.loading').fadeIn();
        $("input, button").prop('disabled', true);
        // Check Form Data
        if(!$('#customer_id').val()){
            alert_msg('warning', 'Select Customer before proceeding');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if(total_amount == 0){
            alert_msg('warning', 'Add Products to this Order before proceeding');
            $('#product_name').addClass('error-border');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($('#schedule_number').val() == 0){
            alert_msg('warning', 'Enter Schedule Number');
            $('#schedule_number').addClass('error-border');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($('#payment_schedule').val() == 0){
            alert_msg('warning', 'Select the Payment Schedule of this Order');
            $('#payment_schedule').addClass('error-border');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else if($('#payment_amount').val() == 0){
            alert_msg('warning', 'Enter your Payment Amount');
            $('#payment_amount').addClass('error-border');
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else{
            
            var customer_id = $('#customer_id').val();
            var payment_schedule = $('#payment_schedule').val();
            var schedule_number = $('#schedule_number').val();
            var payment_amount = $('#payment_amount').val();
            
            /* This Form will update 3 Tables
            /* 1. loan_orders
            /* 2. loan_products
            /* 3. loan_payment_schedule
            */
            
            var loan_order_id;
            
            // Inserting in the loan_orders
            var post_data = {
                customer_id : customer_id,
                order_amount : parseInt(total_amount)
            }
            var url = 'process/new_order_process.php';
            
            $.post(url, post_data, function(result){
                if(result > 0){
                    loan_order_id = result; 
        
                    // Inserting in the loan_products
                    
                    $.post('process/order_products_process.php', {'products':products, 'order_id': loan_order_id}, function(result){
                        $("input, button").prop('disabled', false);
                        alert_msg('success', 'New Order successfully added');
                        console.log(result);
                        $('.loading').fadeOut();
                    });
                }else{
                    alert_msg('danger', 'There was an Internal Problem, Please contact the Administration');
                    $("input, button").prop('disabled', false);
                    
                    
                    $('.loading').fadeOut();
                }
                
            });
        }
        
        e.preventDefault();
    });
    
    
    
});