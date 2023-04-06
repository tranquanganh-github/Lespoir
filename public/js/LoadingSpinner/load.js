function showLoad() {
    $("#overlay").fadeIn(300);
}

function hiddenLoad() {
    setTimeout(function(){
        $("#overlay").fadeOut(300);
    },0);
}
