/**
 * Created by halain on 01-Nov-16.
 */
$(document).ready(function(){
    $('.go-up').hide();
    $('.go-up').click(function(){
        $('body,html').animate({
            scrollTop:0
        },1000)
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() &gt; 200) {
            $('.go-up').fadeIn();
        }
        else {
            $('.go-up').fadeOut();
        }
    });
});
