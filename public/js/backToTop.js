$(document).ready(function(){
    //Click event to scroll to top
    $('.back-to-top').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
});