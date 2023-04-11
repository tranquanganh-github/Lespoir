let provinceAddress;
let districtAddress;
let wardAddress;
let countryName;


function updateAddress() {

    provinceAddress = $("select[name=ls_province]").val() ?? "";
    districtAddress = $("select[name=ls_district]").val() ?? "";
    wardAddress = $("select[name=ls_ward]").val() ?? "";

    let value;
    if (provinceAddress != "") {
        value = provinceAddress;
    }
    if (districtAddress != "") {
        value += ',' + districtAddress;
    }
    if (wardAddress != "") {
        value += ',' + wardAddress;
    }
    $("input[name=address]").val(value);

}

$(function () {

    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
    var iti = window.intlTelInput(input, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js",
        autoHideDialCode: false,
        autoPlaceholder: "aggressive",
        initialCountry: "auto",
        separateDialCode: true,
        preferredCountries: ['ru', 'th'],

    });

    var reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
        var iti = window.intlTelInputGlobals.getInstance(input);
        countryName = iti.getSelectedCountryData();
        document.getElementById('country').value = countryName;
    };

// on blur: validate
    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

// on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

    var $form = $("form"),
        $successMsg = $(".alert");

    function submitForm() {
        var data = $form.serializeArray();
        data.push({name: 'data_phone', value: countryName.dialCode});
        $.ajax({
            type: "POST",
            url: "http://computer.test:90/register",
            data: data
            ,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
        });
    }

    $.validator.addMethod("username", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9_.-]*$/);
    });
    $.validator.addMethod("password", function (value, element) {
        return this.optional(element) || value == value.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/);
    });
    $.validator.addMethod("email", function (value, element) {
        return this.optional(element) || value == value.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/);
    });
    $.validator.addMethod("full_name", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+/);
    });


    $form.validate({
        rules: {
            username: {
                required: true,
                username: true,
                minlength: 8
            },
            password: {
                required: true,
                password: true,
            },
            config_password: {
                required: true,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true,
            },
            address: {
                required: true,
            },
            leyka_donor_phone: {
                required: true,
            },
            name: {
                required: true,
                full_name: true,
            },
            // last_name: {
            //     required: true,
            //     full_name: true,
            // },
        },
        messages: {
            username: {
                required: "Account cannot be empty",
                username: "Account contains only alphanumeric",
                minlength: "Account to short",
            },
            password: {
                required: "Password cannot be blank",
                password: "Password must have at least 8 characters, at least 1 uppercase letter, number, and special character",
            },
            config_password: {
                required: "Verify password cannot be blank",
                password: "Password does not match",
            },
            leyka_donor_phone: "Phone cannot be blank",
            address: "Address cannot be empty",
            email: {
                required: "Email cannot be blank",
                email: "Invalid email format",
            },
            name: {
                required: "Last Name cannot be empty",
                full_name: "malformed",
            },
            // last_name: {
            //     required: "Name cannot be blank",
            //     full_name: "malformed",
            // },

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

})
var localpicker = new LocalPicker({
    province: "ls_province",
    district: "ls_district",
    ward: "ls_ward",
    /*
    Define value for option tag. Valid option: id|name
    */
    getValueBy: 'name',

    //Placeholder text
    provinceText: 'Select province/city',
    districtText: 'Select district/district',
    districtNoText: 'This locality has no district/district',
    wardText: 'Select ward/commune',
    wardNoText: 'This locality has no wards/communes',

    // Default value if no location exist
    emptyValue: " ",

    // Hide option where no local exist
    hideEmptyValueOption: true,

    // Hide place-holder option (first option)
    hidePlaceHolderOption: true,

    /*
    Include local level on option text as prefix
    Example: true = Quận Bình Thạnh | false = Bình Thạnh
    */
    provincePrefix: false,
    districtPrefix: true,
    wardPrefix: true,

    /*
    Include local level in option tag's attribute
    */
    levelAsAttribute: true,
    levelAttributeName: "data-level",
});


