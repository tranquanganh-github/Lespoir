$(function () {
    var $form = $(".form");
    $.validator.addMethod("full_name", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9.]*$/);
    });

    $form.validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            address: {
                required: true,
            },
            phone: {
                required: true
            },
            name: {
                required: true,
                full_name: true,
            },
        },
        messages: {

            phone: {
                required:"Phone cannot be blank",
                phone:"Invalid phone format",
            },
            address: {
                required:"Address cannot be empty",

            },
            email: {
                required: "Email cannot be blank",
                email: "Invalid email format",
            },
            name: {
                required: "Last Name cannot be empty",
                full_name: "malformed",
            },

        },
        submitHandler: function () {
            var data = $form.serializeArray();
            data.push({name: 'data_phone', value: countryName.dialCode});
            $.ajax({
                type: "POST",
                url:registerURL,
                data: data
                ,
                dataType: "json",
                encode: true,
                success: function (data) {
                    switch (data.status) {
                        case STATUS_SUCCESS:
                            alertMethod(data.message, "success");
                            break;
                        case STATUS_FAIL:
                            alertMethod(data.message, "error");
                            break;
                        case STATUS_MISS_DATA:
                            alertMethod(data.message, "warning");
                            break;
                        default:
                            alertMethod("Error System", "warning");
                            break;
                    }
                },erorr:function(){
                    alertMethod("Error System", "warning");
                }
            });
        }
    });
});