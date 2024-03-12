/*==============================================================*/
// Lizo Contact Form  JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#contactForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Did you fill in the form properly?");
        } 
        else {
            event.preventDefault();
            submitForm();
        }
    });

    function submitForm(){


        $.ajax({
            type: "POST",
            url: base_url + '/submit-query',
            data: $("#contactForm").serialize(),
            success : function(statustxt){
                console.log(statustxt);
                if (statustxt.success){
                    formSuccess(statustxt.message);
                } 
                else {
                    formError(statustxt);
                }
            },
            error: function (err) {
                $(".help-block").html('');
                for (let v1 of Object.keys( err.responseJSON.errors)) {
                    $("."+v1).html(Object.values(err.responseJSON.errors[v1]));
                }
            }
        });
    }

    function formSuccess(message){
        $("#contactForm")[0].reset();
        submitMSG(true, message)
    }

    function formError(message){
        $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
        submitMSG(false, message);
    }

    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h4 tada animated text-success";
        } 
        else {
            var msgClasses = "h4 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
}(jQuery)); // End of use strict