$(function() {
  
    // Add Customer Button
    $('#add_customer_btn').click(function(){
        $(this).addClass('nav-hover');
        $('.loading').fadeIn();
        $('#inner-content').delay(500).load('includes/new_customer_form.php');
        $('#inner-content').fadeIn();
        $('.loading').fadeOut();
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
                success:function(data, textStatus, jqXHR){
                    //data: return data from server
                    $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //if fails      
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
    
});