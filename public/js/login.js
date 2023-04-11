var $form = $("form"),
    $successMsg = $(".alert");
// $.validator.addMethod("username", function(value, element) {
//     return this.optional(element) || value == value.match(/^[a-zA-Z0-9_.-]*$/);
// });
// $.validator.addMethod("password", function(value, element) {
//     return this.optional(element) || value == value.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/);
// });
$form.validate({
    rules: {
        username: {
            required: true,
            // username: true
        },
        password: {
            required: true,
            // password: true
        }
    },
    messages: {
        username: "Account cannot be empty",
        password: "password cannot be blank"
    },
    submitHandler: function(event) {
        var data = $form.serializeArray();
        showLoad();
        $.ajax({
            type: "POST",
            url:loginURL,
            data: data
            ,
            dataType: "json",
            encode: true,
            success: function (data) {

                switch (data.status) {
                    case STATUS_SUCCESS:
                        alertMethod(data.message, "success");
                        // setCookie("token",data.data.token,30);

                        setTimeout(function(){
                            window.location.href = data.data.redirect;
                        },1000);

                        break;
                    case STATUS_FAIL:
                        alertMethod(data.message, "error");
                        break;
                    default:
                        alertMethod("Error System", "warning");
                        break;
                }
                hiddenLoad();
            },error:function (){
                hiddenLoad();
                alertMethod("Error System", "warning");

            }
        });
    }
});

function submitLogin(){
    $form.submit();
}

