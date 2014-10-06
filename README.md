loans
=====

A Loan Management System that will handle from date loan was taken and SMS follow up. 
if($('input').val() == ''){
            $("input, button").prop('disabled', false);
            $('.loading').fadeOut();
        }else{
            $("input, button").prop('disabled', true);
            $("button[type='submit']").html("<i class='fa fa-cog fa-spin text-desaturated-blue'></i> Loading...");

            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR) 
                {
                    //data: return data from server
                    alert('awesome');
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails  
                    alert('Boomer');
                }
            });
        }