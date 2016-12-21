//Function for scrolling back to the top
$(document).ready(function(){
    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 20) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    //Click event to scroll to top
    $('.back-to-top').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    //Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent
    window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":"https://belle-idee.org/cookies","theme":"light-bottom"};
    <!-- End Cookie Consent plugin -->
});
