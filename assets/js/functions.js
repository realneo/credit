$(function() {
    
    function alert_msg(alert_type, alert_msg){
        $('.alert p').html(alert_msg);
        if(alert_type == 'warning'){
            $('.alert_msg').addClass('warning-bg');    
        }else if(alert_type == 'success'){
            $('.alert_msg').addClass('success-bg');    
        }else{
            $('.alert_msg').addClass('error-bg');                             
        }
        
        $('.alert_msg').fadeIn().delay(10000).fadeOut();
    }
    
});