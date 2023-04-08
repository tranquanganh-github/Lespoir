let confirm = "true";

function order(event){
    event.preventDefault();


    var data =getData();
    if (data.carts.length <= 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'SYou have no products in your shopping cart!',
        })
    }else{
        showLoad();
    sendAjax(CheckoutUrl,data);
    }
}
 $("form[name=paypal]").submit(function (e){
    e.preventDefault();
   var data = getData();
    if (data.carts.length <= 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'SYou have no products in your shopping cart!',
        })
    }else{
        ajaxPaypal(PayPalCheckoutUrl,data);
    }
});


function alertMethod(message,icon){
    Swal.fire({
        icon: icon,
        title: message ?? "",
    });
}

function archiveFunction(message) {
    Swal.fire({
        title: message,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Order',
        denyButtonText: `Refuse to order`,
    }).then((result) => {
        if (result.isConfirmed) {
            sendAjax(CheckoutUrl,getData());
            confirm = "true";
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })

}
function getData(){
    var carts = [];
    $(".data-cart").each((key,element) => {
        carts.push( {
            name:$(element).data("name"),
            id:$(element).data("id"),
            quantity:$(element).data("quantity"),
            price:$(element).data("price"),
        });
    });
    return {
        carts:carts,
        shipping:$(".shipping-price").val(),
        name:$("input[name=name]").val(),
        email:$("input[name=email]").val(),
        address:$("input[name=address]").val(),
        phone:$("input[name=phone]").val(),
        message:$("textarea[name=bill]").val(),
        confirm:confirm,
    }
}
function sendAjax(url,data){
    $.ajax({
        type: "POST",
        url:url,
        data: data,
        dataType: "json",
        encode: true,
        success:  function (data) {
            hiddenLoad();
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
                case CONFORM:
                    confirm = "false";
                    archiveFunction(data.message);
                    break;
                default:
                    alertMethod("Error System", "error");
                    break;
            }
        },
        error: function (){
        hiddenLoad();
        alertMethod("Error System", "error");
    },
    });
}
function ajaxPaypal(url,data){
    $.ajax({
        type: "POST",
        url:url,
        data: data,
        dataType: "json",
        encode: true,
        success:  function (data) {
            hiddenLoad();
            switch (data.status) {
                case STATUS_SUCCESS:
                        window.location.href = data.data.paypal_link;
                    break;
                case STATUS_FAIL:
                    alertMethod(data.message, "error");
                    break;
                case STATUS_MISS_DATA:
                    alertMethod(data.message, "warning");
                    break;
                default:
                    alertMethod("Error System", "error");
                    break;
            }
        },
        error: function (){
            hiddenLoad();
            alertMethod("Error System", "error");
        },
    });
}