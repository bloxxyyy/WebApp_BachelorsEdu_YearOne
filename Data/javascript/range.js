function updateTextInput(val) {
    document.getElementById('rangeCount').innerText='€' + val;
}



$(function(){
    $('.countdown').each(function(){
        $(this).countdown($(this).attr('value'), function(event) {
            $(this).text(
                event.strftime('%Dd %Hu %Mm %Ss')
            );
        });
    });
});